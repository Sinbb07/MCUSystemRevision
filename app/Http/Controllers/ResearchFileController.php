<?php

namespace App\Http\Controllers;

use App\Models\ResearchInformation;
use Illuminate\Http\Request;
use App\Models\FormsTable;
use App\Models\ResearchFiles;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FileUploaded;
use App\Notifications\DocumentDeletedNotification;
use App\Mail\DocumentDeletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\ProcessMonitoring;
use Illuminate\Support\Facades\Storage;

class ResearchFileController extends Controller
{
    public function showForm($formId)
    {
        $student = auth()->user();

        // find the form assigned to this student
        $form = $student->forms()
            ->where('tbl_forms.form_type', 'Submission')
            ->where('tbl_forms.form_id', $formId)
            ->firstOrFail();

        // check if the current student already submitted
        $submitted = ResearchFiles::where('user_ID', $student->user_ID)
            ->where('form_id', $formId)
            ->exists();

        return view('student.submit-form-layout', compact('form', 'submitted'));
    }

    public function storeSubmission(Request $request, $formId)
    {
        $request->validate([
            'uploadForms.*' => 'required|mimes:doc,docx,pdf|max:2048',
        ]);

        $user = auth()->user();
        $folderPath = "researchFolder/{$user->user_ID}";

        if ($request->hasFile('uploadForms')) {
            foreach ($request->file('uploadForms') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();

                // Save file into storage/app/public/researchFolder/{user_ID}
                $filePath = $file->storeAs($folderPath, $filename, 'public');

                // Insert record
                ResearchFiles::create([
                    'user_ID'      => $user->user_ID,
                    'form_id'      => $formId,
                    'file_name'    => $filename,
                    'file_path'    => $filePath,
                    'submitted_at' => now(),
                ]);

                // ✅ ADDED PROCESS MONITORING: PI Submits Forms (OUTGOING)
                ProcessMonitoring::create([
                    'process_code' => 'PI6',
                    'process_description' => 'Submit forms to ERB/IACUC: ' . $filename,
                    'user_type' => 'pi',
                    'direction' => 'out',
                    'timestamp' => now(),
                    'action_by_user_id' => $user->user_ID,
                    'action_by_user_type' => 'pi',
                    'affected_user_id' => null,
                    'affected_user_type' => null,
                ]);

                // Determine which admins to notify based on user classification
                $adminUsers = collect();

                // Check user classification (assuming these fields exist in your users table)
                if ($user->classification === 'IACUC') {
                    $adminUsers = $adminUsers->merge(User::where('user_Access', 'IACUC Admin')->get());
                    
                    // ✅ ADDED PROCESS MONITORING: IACUC Admin Receives Forms (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'IAC2',
                        'process_description' => 'Received IACUC forms from PI: ' . $filename,
                        'user_type' => 'admin_iacuc',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $user->user_ID,
                        'action_by_user_type' => 'pi',
                        'affected_user_id' => null,
                        'affected_user_type' => 'admin_iacuc',
                    ]);
                } 
                elseif ($user->classification === 'ERB') {
                    $adminUsers = $adminUsers->merge(User::where('user_Access', 'ERB Admin')->get());
                    
                    // ✅ ADDED PROCESS MONITORING: ERB Admin Receives Forms (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'ERB2',
                        'process_description' => 'Received forms from PI: ' . $filename,
                        'user_type' => 'admin_erb',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $user->user_ID,
                        'action_by_user_type' => 'pi',
                        'affected_user_id' => null,
                        'affected_user_type' => 'admin_erb',
                    ]);
                } 
                elseif ($user->classification === 'BOTH') {
                    $iacucAdmins = User::where('user_Access', 'IACUC Admin')->get();
                    $erbAdmins = User::where('user_Access', 'ERB Admin')->get();
                    $adminUsers = $adminUsers->merge($iacucAdmins)->merge($erbAdmins);
                    
                    // ✅ ADDED PROCESS MONITORING: Both Admins Receive Forms (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'IAC2',
                        'process_description' => 'Received IACUC forms from PI: ' . $filename,
                        'user_type' => 'admin_iacuc',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $user->user_ID,
                        'action_by_user_type' => 'pi',
                        'affected_user_id' => null,
                        'affected_user_type' => 'admin_iacuc',
                    ]);
                    
                    ProcessMonitoring::create([
                        'process_code' => 'ERB2',
                        'process_description' => 'Received forms from PI: ' . $filename,
                        'user_type' => 'admin_erb',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $user->user_ID,
                        'action_by_user_type' => 'pi',
                        'affected_user_id' => null,
                        'affected_user_type' => 'admin_erb',
                    ]);
                }

                if ($adminUsers->isNotEmpty()) {
                    Notification::send($adminUsers, new FileUploaded($user, $formId, $filename));
                }
            }
        }

        return redirect()->back()->with('success', 'Files submitted successfully!');
    }

    public function submittedDocumentsERB($userId)
    {   
         $user = User::findOrFail($userId);
        
        // Check if user is classified for ERB or BOTH
        if (!$user->classifications || !in_array($user->classifications->reviewClassification, ['ERB', 'BOTH'])) {
            return redirect()->back()->with('error', 'This user is not classified for ERB submissions.');
        }

        $piFiles = User::with(['researchFiles' => function($query) {
            $query->where('status', 'active'); // Only show active files
        }])->findOrFail($userId);

        return view('erb.submitted-documents', compact('piFiles', 'user'));
    }

    // Add this method to handle soft deletion
    public function softDeleteResearchFile($fileId, Request $request)
    {
        try {
            $researchFile = ResearchFiles::findOrFail($fileId);
            $deleteReason = $request->input('delete_reason', 'No reason provided');
            
            // Update file status
            $researchFile->update(['status' => 'inactive']);
            
            $user = $researchFile->user;
            
            $notificationData = [
                'message' => 'Your document has been deleted by an administrator.',
                'document_name' => $researchFile->file_name,
                'form_name' => $researchFile->form?->form_name ?? 'Unknown Form',
                'form_to_resubmit' => $researchFile->form?->form_name ?? 'the required form', // Added this
                'deleted_at' => now()->format('Y-m-d H:i:s'),
                'delete_reason' => $deleteReason,
                'action_url' => '#',
                'type' => 'document_deleted'
            ];
            
            // Send email and notification if user exists AND has email
            if ($user && !empty($user->user_Email)) {
                Mail::to($user->user_Email)->queue(new DocumentDeletedMail($user, $notificationData));
                
                // Send system notification to the user
                $user->notify(new DocumentDeletedNotification($notificationData));
            }
            
            return redirect()->back()->with('success', 'Document deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting document: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting document');
        }
    }
    public function researchRecords()
    {
        $researchRecords = ResearchInformation::with([
            // Load the P.I. user and their related data
            'user' => function ($query) {
                $query->with([
                    // Load all submitted files
                    'researchFiles',
                    // Load all initial reviews and reviewers
                    'initialReviews' => function ($q) {
                        $q->with([
                            'protocol',
                            'reviewer1',
                            'reviewer2',
                        ]);
                    },
                    // Load approved decisions
                    'approved',
                    'classifications' // Use the plural relationship name
                ]);
            },
        ])->whereHas('user.classifications', function ($query) {
            $query->whereIn('reviewClassification', ['ERB', 'BOTH']);
        })->get();
        return view('erb.research-records', compact('researchRecords'));
    }

    public function researchRecordsIacuc()
    {
        $researchRecords = ResearchInformation::with([
            'user' => function ($query) {
                $query->with([
                    'researchFiles',
                    'initialReviews' => function ($q) {
                        $q->with([
                            'protocol',
                            'reviewer1',
                            'reviewer2',
                        ]);
                    },
                    'approved',
                    'classifications' // Use the plural relationship name
                ]);
            },
        ])->whereHas('user.classifications', function ($query) {
            $query->whereIn('reviewClassification', ['IACUC', 'BOTH']);
        })->get();

        return view('iacuc.research-records', compact('researchRecords'));
    }

    /*LAHAT NG IACUC CLASS DITOOOO*/
    public function submittedDocumentsIacuc($userId)
    {
        $user = User::findOrFail($userId);
        
        // Check if user is classified for IACUC or BOTH
        if (!$user->classifications || !in_array($user->classifications->reviewClassification, ['IACUC', 'BOTH'])) {
            return redirect()->back()->with('error', 'This user is not classified for IACUC submissions.');
        }
        
        $piFiles = User::with(['researchFiles' => function($query) {
            $query->where('status', 'active');
        }])->findOrFail($userId);

        return view('iacuc.submitted-documents', compact('piFiles', 'user'));
    }
}
