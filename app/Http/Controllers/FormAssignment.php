<?php

namespace App\Http\Controllers;

use App\Models\FormsTable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ResearchFiles;
use App\Notifications\FormsAssigned;
use App\Models\ProcessMonitoring;
use Illuminate\Support\Facades\Notification;
use App\Models\Classification;
use Illuminate\Support\Facades\DB;
class FormAssignment extends Controller
{
    /**
     * Display approved accounts for ERB - Only ERB classified PIs
     */
    public function approvedAccounts()
    {
        // Get all user IDs that are classified as ERB
        $classifiedUserIds = Classification::where('reviewClassification', 'ERB')
            ->pluck('user_ID')
            ->toArray();

        if (empty($classifiedUserIds)) {
            $approvedAccounts = collect();
        } else {
            $approvedAccounts = User::with(['forms', 'researchInformation', 'classifications'])
                ->whereIn('user_Access', ['Principal Investigator'])
                ->whereIn('user_ID', $classifiedUserIds)
                ->whereHas('classifications', function ($q) {
                    $q->where('classificationStatus', 'Approved')
                      ->where('reviewClassification', 'ERB');
                })
                ->get()
                ->sortBy(function($user) {
                    return $user->forms->isNotEmpty() ? 1 : 0;
                });
        }

        $selectForms = FormsTable::whereIn('form_code', [
            'Form 2(A)',
            'Form 2(B)',
            'Form 2(C)',
            'Form 2(D)',
            'Form 5(E)',
            'FORM 2(A) Soft Copy',
            'FORM 2(B) Soft Copy',
            'Proof of Enrollment',
            'Technical Review Letter',
            'Study Protocol',
            'Form 2(C) Soft Copy - ENG',
            'Form 2(C) Soft Copy - FIL',
            'Data Collection Tools',
            'Certificates of Validators',
            'Child Assent for Children Ages 7-12 years - ENG',
            'Child Assent for Children Ages 7-12 years - FIL',
            'Child Assent for Children Ages 13-17 years - ENG',
            'Child Assent for Children Ages 13-17 years - FIL',
            'Recruitment advertisement',
            'Curriculum Vitae',
            'Good Clinical Practice (GCP) or Health Research Ethics Training Certificate',
            'Gantt chart',
        ])->get();

        return view('erb.iro-approved-accounts', compact('selectForms','approvedAccounts'));
    }

    /**
     * Display approved accounts for IACUC - Only IACUC classified PIs
     */
    public function IACUCapprovedAccounts()
    {
        $classifiedUserIds = Classification::where('reviewClassification', 'IACUC')
            ->pluck('user_ID')
            ->toArray();

        if (empty($classifiedUserIds)) {
            $approvedAccounts = collect();
        } else {
            $approvedAccounts = User::with(['forms', 'researchInformation', 'classifications'])
                ->whereIn('user_Access', ['Principal Investigator'])
                ->whereIn('user_ID', $classifiedUserIds)
                ->whereHas('classifications', function ($q) {
                    $q->where('classificationStatus', 'Approved')
                      ->where('reviewClassification', 'IACUC');
                })
                ->get()
                ->sortBy(function($user) {
                    return $user->forms->isNotEmpty() ? 1 : 0;
                });
        }

        return view('iacuc.iro-approved-accounts', compact('approvedAccounts'));
    }

    /**
     * Assign forms to ERB classified PIs
     */
    public function assignFormsAjax(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|string',
            'form_ids' => 'nullable|array',
            'form_ids.*' => 'nullable|integer',
            'remove_form_ids' => 'nullable|array',
            'remove_form_ids.*' => 'nullable|integer',
        ]);

        $erbUserIds = Classification::where('reviewClassification', 'ERB')
            ->pluck('user_ID')
            ->toArray();

        $totalAssignedCount = 0;
        $totalRemovedCount = 0;

        foreach ($request->user_ids as $userId) {
            if (!in_array($userId, $erbUserIds)) {
                continue;
            }

            $user = User::find($userId);

            if ($user) {
                // Assign new forms
                if ($request->has('form_ids') && !empty($request->form_ids)) {
                    $newForms = [];
                    foreach ($request->form_ids as $formId) {
                        $exists = DB::table('tbl_form_user')
                            ->where('user_ID', $userId)
                            ->where('form_id', $formId)
                            ->exists();
                        
                        if (!$exists) {
                            DB::table('tbl_form_user')->insert([
                                'user_ID' => $userId,
                                'form_id' => $formId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $totalAssignedCount++;
                            $newForms[] = $formId;
                        }
                    }
                    
                    if (!empty($newForms)) {
                        $user->notify(new FormsAssigned($newForms));
                    }
                }
                
                // Remove forms
                if ($request->has('remove_form_ids') && !empty($request->remove_form_ids)) {
                    foreach ($request->remove_form_ids as $formId) {
                        DB::table('tbl_form_user')
                            ->where('user_ID', $userId)
                            ->where('form_id', $formId)
                            ->delete();
                        $totalRemovedCount++;
                    }
                }
            }
        }

        $message = "";
        if ($totalAssignedCount > 0) $message .= "✅ Assigned {$totalAssignedCount} new form(s). ";
        if ($totalRemovedCount > 0) $message .= "🗑️ Removed {$totalRemovedCount} form(s). ";
        if (empty($message)) $message = "No changes were made.";

        return response()->json([
            'success' => true, 
            'message' => $message,
            'assigned' => $totalAssignedCount,
            'removed' => $totalRemovedCount
        ]);
    }

    /**
     * Assign default forms to IACUC classified PIs
     */
    public function assignDefaultFormsAjax(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
        ]);

        $defaultFormIds = [45, 46, 53];

        $iacucUserIds = Classification::where('reviewClassification', 'IACUC')
            ->pluck('user_ID')
            ->toArray();

        foreach ($request->user_ids as $userId) {
            if (!in_array($userId, $iacucUserIds)) {
                continue;
            }

            $user = User::find($userId);

            if ($user) {
                $user->forms()->syncWithoutDetaching($defaultFormIds);
                $user->notify(new FormsAssigned($defaultFormIds));
            }
        }

        return response()->json(['success' => true, 'message' => 'Default forms assigned successfully!']);
    }

    public function assignedFormsDisplay()
    {
        $student = auth()->user();
        
        $assignedForms = $student->forms()
            ->where('form_type', 'Forms')
            ->get();

        return view('student.submit-forms', compact('assignedForms'));
    }

    public function assignedSubmissionDisplay()
    {
        $student = auth()->user();

        $submissionForms = $student->forms()
            ->where('form_type', 'Submission')
            ->get()
            ->map(function($form) use ($student) {
                $submission = ResearchFiles::where('user_ID', $student->user_ID)
                    ->where('form_id', $form->form_id)
                    ->where('status', 'active')
                    ->latest()
                    ->first();
                
                $form->is_submitted = !is_null($submission);
                
                if ($form->is_submitted) {
                    $form->submitted_at = $submission->submitted_at;
                } else {
                    $form->submitted_at = null;
                }
                
                return $form;
            });
        
        return view('student.submit-documents', compact('submissionForms'));
    }

    /**
     * Display assigned forms logs for ERB
     * FIXED: Now only shows ERB classified PIs
     */
    public function assignedFormsLogs()
    {
        // Get all user IDs that are classified as ERB only
        $classifiedUserIds = Classification::where('reviewClassification', 'ERB')
            ->pluck('user_ID')
            ->toArray();

        // If no classified users, return empty collection
        if (empty($classifiedUserIds)) {
            $approvedAccounts = collect();
        } else {
            // Get only ERB classified PIs with their forms
            $approvedAccounts = User::with(['forms', 'researchInformation', 'classifications'])
                ->whereIn('user_Access', ['Principal Investigator'])
                ->whereIn('user_ID', $classifiedUserIds)
                ->whereHas('classifications', function ($q) {
                    $q->where('classificationStatus', 'Approved')
                      ->where('reviewClassification', 'ERB');
                })
                ->get();
        }

        $selectForms = FormsTable::whereIn('form_code', [
            'Form 2(A)','Form 2(B)','Form 2(C)','Form 2(D)','Form 5(E)',
            'FORM 2(A) Soft Copy','FORM 2(B) Soft Copy','Proof of Enrollment',
            'Technical Review Letter','Study Protocol','Form 2(C) Soft Copy - ENG',
            'Form 2(C) Soft Copy - FIL','Data Collection Tools','Certificates of Validators',
            'Child Assent for Children Ages 7-12 years - ENG',
            'Child Assent for Children Ages 7-12 years - FIL',
            'Child Assent for Children Ages 13-17 years - ENG',
            'Child Assent for Children Ages 13-17 years - FIL',
            'Recruitment advertisement','Curriculum Vitae',
            'Good Clinical Practice (GCP) or Health Research Ethics Training Certificate',
            'Gantt chart',
        ])->get();

        return view('erb.assigned-forms', compact('approvedAccounts','selectForms'));
    }
}