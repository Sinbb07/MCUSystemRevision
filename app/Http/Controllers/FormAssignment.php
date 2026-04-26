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
            'form_ids' => 'required|array',
        ]);

        $erbUserIds = Classification::where('reviewClassification', 'ERB')
            ->pluck('user_ID')
            ->toArray();

        foreach ($request->user_ids as $userId) {
            if (!in_array($userId, $erbUserIds)) {
                continue;
            }

            $user = User::find($userId);

            if ($user) {
                $user->forms()->syncWithoutDetaching($request->form_ids);
                $user->notify(new FormsAssigned($request->form_ids));

                ProcessMonitoring::create([
                    'process_code' => 'ERB5',
                    'process_description' => 'Assign initial forms to PI',
                    'user_type' => 'admin_erb',
                    'direction' => 'out',
                    'timestamp' => now(),
                    'action_by_user_id' => auth()->user()->user_ID,
                    'action_by_user_type' => 'admin_erb',
                    'affected_user_id' => $user->user_ID,
                    'affected_user_type' => 'pi',
                ]);

                ProcessMonitoring::create([
                    'process_code' => 'PI2',
                    'process_description' => 'Received initial forms from admin',
                    'user_type' => 'pi',
                    'direction' => 'in',
                    'timestamp' => now(),
                    'action_by_user_id' => auth()->user()->user_ID,
                    'action_by_user_type' => 'admin_erb',
                    'affected_user_id' => $user->user_ID,
                    'affected_user_type' => 'pi',
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Forms assigned successfully!']);
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