<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\InitialReview;
use App\Models\User;
use App\Models\ResearchFiles;
use App\Models\FormsTable;
use App\Models\Protocol;
use App\Notifications\ReviewerProgress;
use App\Notifications\ReviewCompleted;
use App\Models\EvaluatedReviews;
use App\Models\ProcessMonitoring;
use App\Models\ReviewerFile;
use App\Models\IacucProtocolReview;

class ERBReviewer extends Controller
{
    public function index()
    {
        $reviewerId = Auth::user()->user_ID;

        // Get assignments from InitialReview, but exclude those the reviewer declined
        $assignedProtocols = InitialReview::with(['protocol.user', 'protocol.initialReviews.form'])
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->whereDoesntHave('protocol.evaluatedReviews', function($q) use ($reviewerId) {
                $q->where('reviewer_ID', $reviewerId)
                ->where('status', 'Declined');
            })
            ->get()
            ->groupBy('protocol_ID');

        return view('erb-reviewer.protocol-assign', compact('assignedProtocols'));
    }

    public function showSubmittedDocuments(Request $request)
    {
        $userId = $request->query('user_id');

        // Find PI and load all submitted research files with related form info
        $pi = User::with(['researchFiles.form', 'classifications'])
            ->where('user_ID', $userId)
            ->first();

        if (!$pi->classifications || !in_array($pi->classifications->reviewClassification, ['ERB', 'BOTH'])) {
            return back()->with('error', 'This user is not classified for ERB submissions.');
        }

        $files = $pi->researchFiles; // All files submitted by this user

        return view('erb-reviewer.submitted-documents', compact('pi', 'files'));
    }

    public function showSubmitDocuments($form, Request $request)
    {
        $reviewerId = Auth::user()->user_ID;
        $formId = $form; // The route parameter is named 'form'
        
        // Get protocol_id from URL parameter
        $protocolId = $request->query('protocol_id');
        
        // If not in URL, try to get from assignment
        if (!$protocolId) {
            $assignedForm = InitialReview::where('form_id', $formId)
                ->where(function ($q) use ($reviewerId) {
                    $q->where('reviewer1_ID', $reviewerId)
                        ->orWhere('reviewer2_ID', $reviewerId);
                })
                ->first();
            
            if ($assignedForm) {
                $protocolId = $assignedForm->protocol_ID;
            }
        }
        
        $formData = FormsTable::where('form_id', $formId)->firstOrFail();
        
        // Get submitted files for this specific form AND protocol
        $submittedFiles = ReviewerFile::where('form_id', $formId)
            ->where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('erb-reviewer.submit-documents', compact('formData', 'submittedFiles', 'protocolId'));
    }

    public function submitForm(Request $request, $form)
    {
        $reviewerId = Auth::user()->user_ID;
        $formId = $form; // The route parameter is named 'form'

        // Validate uploaded files
        $request->validate([
            'uploadForms.*' => 'required|file|mimes:doc,docx,pdf|max:10240'
        ]);

        // Get protocol_id from request
        $protocolId = $request->input('protocol_id');
        
        if (!$protocolId) {
            $assignedForm = InitialReview::where('form_id', $formId)
                ->where(function ($q) use ($reviewerId) {
                    $q->where('reviewer1_ID', $reviewerId)
                        ->orWhere('reviewer2_ID', $reviewerId);
                })
                ->first();

            if ($assignedForm) {
                $protocolId = $assignedForm->protocol_ID;
            }
        }

        if (!$protocolId) {
            return redirect()->back()->with('error', 'Unable to determine protocol for this submission.');
        }

        // Get form data
        $formData = FormsTable::where('form_id', $formId)
            ->where('form_type', 'Submission')
            ->firstOrFail();

        // Verify if form is assigned to this reviewer with this protocol
        $assignedForm = InitialReview::where('form_id', $formId)
            ->where('protocol_ID', $protocolId)
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->first();

        if (!$assignedForm) {
            return redirect()->back()->with('error', 'This form is not assigned to you for this protocol.');
        }

        // Check if reviewer has already submitted for this form AND protocol
        $existingSubmission = ReviewerFile::where('form_id', $formId)
            ->where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->exists();

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted documents for this form.');
        }

        // Save uploaded files
        foreach ($request->file('uploadForms') as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->store("reviewer_files/{$protocolId}", 'public');

            ReviewerFile::create([
                'form_id' => $formData->form_id,
                'protocol_ID' => $protocolId,
                'reviewer_ID' => $reviewerId,
                'file_name' => $filename,
                'file_path' => $path,
            ]);
        }

        // All forms assigned to this reviewer for this protocol
        $assignedForms = InitialReview::where('protocol_ID', $protocolId)
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->pluck('form_id')
            ->unique();

        // Get only Submission-type assigned forms
        $submissionFormIds = FormsTable::whereIn('form_id', $assignedForms)
            ->where('form_type', 'Submission')
            ->pluck('form_id');

        // Forms that reviewer has already submitted
        $submittedForms = ReviewerFile::where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->pluck('form_id')
            ->unique();

        // Determine progress
        $allSubmitted = $submissionFormIds->diff($submittedForms)->isEmpty();
        $status = $allSubmitted ? 'Completed' : 'In Progress';

        // Always record or update in tbl_evaluated_reviews
        EvaluatedReviews::updateOrCreate(
            [
                'protocol_ID' => $protocolId,
                'reviewer_ID' => $reviewerId
            ],
            [
                'status' => $status,
                'completed_at' => $allSubmitted ? now() : null
            ]
        );

        // ✅ ADDED PROCESS MONITORING: Reviewer Submits Forms (OUTGOING)
        ProcessMonitoring::create([
            'process_code' => 'REV_ERB4',
            'process_description' => 'Submit accomplished forms to ERB admin for protocol: ' . $protocolId,
            'user_type' => 'reviewer_erb',
            'direction' => 'out',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => 'reviewer_erb',
            'affected_user_id' => null,
            'affected_user_type' => 'admin_erb',
        ]);

        // ✅ ADDED PROCESS MONITORING: ERB Admin Receives Forms (INCOMING)
        ProcessMonitoring::create([
            'process_code' => 'ERB4',
            'process_description' => 'Received accomplished forms from reviewer for protocol: ' . $protocolId,
            'user_type' => 'admin_erb',
            'direction' => 'in',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => 'reviewer_erb',
            'affected_user_id' => null,
            'affected_user_type' => 'admin_erb',
        ]);

        // 🔹 NOTIFY ERB ADMINS ABOUT REVIEWER PROGRESS
        $adminUsers = User::where('user_Access', 'ERB Admin')->get();
        
        if ($adminUsers->isNotEmpty()) {
            foreach ($adminUsers as $admin) {
                $admin->notify(new ReviewerProgress($protocolId, $reviewerId, $status, $formId));

                // ✅ ADDED PROCESS MONITORING: Individual Admin Notification
                ProcessMonitoring::create([
                    'process_code' => 'ERB4',
                    'process_description' => 'Reviewer progress notification: ' . $status . ' for protocol ' . $protocolId,
                    'user_type' => 'admin_erb',
                    'direction' => 'in',
                    'timestamp' => now(),
                    'action_by_user_id' => $reviewerId,
                    'action_by_user_type' => 'reviewer_erb',
                    'affected_user_id' => $admin->user_ID,
                    'affected_user_type' => 'admin_erb',
                ]);
            }
        }

        // 🔹 CHECK IF ALL REVIEWERS HAVE COMPLETED THEIR EVALUATIONS
        if ($status === 'Completed') {
            $this->checkAllReviewsCompleted($protocolId);
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    /**
     * Check if all reviewers have completed their evaluations for a protocol
     */
    private function checkAllReviewsCompleted($protocolId)
    {
        // Get all reviewers assigned to this protocol
        $assignedReviewers = InitialReview::where('protocol_ID', $protocolId)
            ->where(function ($q) {
                $q->whereNotNull('reviewer1_ID')
                ->orWhereNotNull('reviewer2_ID');
            })
            ->get();

        $reviewer1Ids = $assignedReviewers->pluck('reviewer1_ID')->filter()->unique();
        $reviewer2Ids = $assignedReviewers->pluck('reviewer2_ID')->filter()->unique();
        $allReviewerIds = $reviewer1Ids->merge($reviewer2Ids)->unique();

        // Check if all reviewers have completed their evaluations
        $completedReviews = EvaluatedReviews::where('protocol_ID', $protocolId)
            ->whereIn('reviewer_ID', $allReviewerIds)
            ->where('status', 'Completed')
            ->count();

        // If all reviewers have completed, notify the student
        if ($allReviewerIds->count() > 0 && $completedReviews === $allReviewerIds->count()) {
            $protocol = Protocol::where('protocol_ID', $protocolId)->first();
            
            if ($protocol) {
                $student = User::find($protocol->user_ID);
                $reviewType = $protocol->review_type;
                
                if ($student) {
                    $student->notify(new ReviewCompleted($protocolId, $reviewType));

                    // ✅ PROCESS MONITORING: PI Notified of Completed Review
                    // Get an ERB admin user ID to use as action_by_user_id
                    $adminUser = User::where('user_Access', 'ERB Admin')->first();
                    
                    ProcessMonitoring::create([
                        'process_code' => 'PI1',
                        'process_description' => 'All reviews completed for protocol: ' . $protocolId,
                        'user_type' => 'pi',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $adminUser ? $adminUser->user_ID : 'system', // Use admin ID or fallback
                        'action_by_user_type' => $adminUser ? 'admin_erb' : 'system',
                        'affected_user_id' => $student->user_ID,
                        'affected_user_type' => 'pi',
                    ]);
                }
            }
        }
    }

    // Replace your existing iacucIndex() method in ERBReviewer.php with this:

    public function iacucIndex()
    {
        $reviewerId = Auth::user()->user_ID;
    
        $assignedProtocols = InitialReview::with(['protocol.user', 'pi', 'form'])
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->whereDoesntHave('protocol.evaluatedReviews', function($q) use ($reviewerId) {
                $q->where('reviewer_ID', $reviewerId)
                ->where('status', 'Declined');
            })
            ->get()
            ->groupBy('protocol_ID');
    
        return view('iacuc-reviewer.protocol-assign', compact('assignedProtocols'));
    }

    public function iacucShowSubmittedDocuments(Request $request)
    {
        $userId = $request->query('user_id');

        // Find PI and load all submitted research files with related form info
        $pi = User::with(['researchFiles.form', 'classifications'])
            ->where('user_ID', $userId)
            ->first();

        if (!$pi->classifications || !in_array($pi->classifications->reviewClassification, ['IACUC', 'BOTH'])) {
            return back()->with('error', 'This user is not classified for IACUC submissions.');
        }

        $files = $pi->researchFiles; // All files submitted by this user

        return view('iacuc-reviewer.submitted-documents', compact('pi', 'files'));
    }

    public function iacucShowSubmitDocuments($formId, Request $request)
    {
        $reviewerId = Auth::user()->user_ID;
        
        // Get protocol_id from URL parameter
        $protocolId = $request->query('protocol_id');
        
        // Get the form
        $form = FormsTable::where('form_id', $formId)->firstOrFail();
        
        // Get submitted files for this specific form AND protocol
        $submittedFiles = ReviewerFile::where('form_id', $formId)
            ->where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('iacuc-reviewer.submit-documents', compact('form', 'submittedFiles', 'protocolId'));
    }

    public function updateReviewStatus(Request $request)
    {
        $request->validate([
            'protocol_id' => 'required|string',
            'status' => 'required|in:Accepted,Declined',
            'decline_reason' => 'required_if:status,Declined|string|min:10|nullable'
        ]);

        $reviewerId = auth()->user()->user_ID;
        $isErb = str_starts_with($request->protocol_id, 'ERB');

        $review = EvaluatedReviews::where('protocol_ID', $request->protocol_id)
            ->where('reviewer_ID', $reviewerId)
            ->first();

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review record not found.'], 404);
        }

        // Update evaluated_reviews
        $review->update([
            'status' => $request->status,
            'decline_reason' => $request->status === 'Declined' ? $request->decline_reason : null,
            'completed_at' => $request->status === 'Accepted' ? null : now()
        ]);

        // ✅ CRITICAL: Update initial_review when declined
        if ($request->status === 'Declined') {
            // Find which position (reviewer1 or reviewer2) this reviewer holds
            $initialReview = InitialReview::where('protocol_ID', $request->protocol_id)
                ->where(function($q) use ($reviewerId) {
                    $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
                })
                ->first();

            if ($initialReview) {
                // Clear the specific reviewer position
                if ($initialReview->reviewer1_ID === $reviewerId) {
                    $initialReview->update(['reviewer1_ID' => null]);
                } elseif ($initialReview->reviewer2_ID === $reviewerId) {
                    $initialReview->update(['reviewer2_ID' => null]);
                }
                
                // Log the clearance
                \Log::info("Reviewer {$reviewerId} cleared from position in protocol {$request->protocol_id}");
            }
        }

        // Dynamic Process Codes based on Protocol Type
        $processCode = '';
        $userType = '';
        if ($isErb) {
            $processCode = $request->status === 'Accepted' ? 'REV_ERB_ACC' : 'REV_ERB_DEC';
            $userType = 'reviewer_erb';
        } else {
            $processCode = $request->status === 'Accepted' ? 'REV_IAC_ACC' : 'REV_IAC_DEC';
            $userType = 'reviewer_iacuc';
        }

        ProcessMonitoring::create([
            'process_code' => $processCode,
            'process_description' => "Reviewer " . auth()->user()->user_Fname . " has " . strtolower($request->status) . " the review for protocol: " . $request->protocol_id . 
                ($request->status === 'Declined' ? " Reason: " . $request->decline_reason : ""),
            'user_type' => $userType,
            'direction' => 'out',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => $userType,
        ]);

        return response()->json(['success' => true]);
    }

    public function iacucProtocolReviewChecklist(Request $request)
    {
        $protocolId = $request->query('protocol');
        $reviewerId = Auth::user()->user_ID;

        // Ensure authorization
        $assigned = InitialReview::where('protocol_ID', $protocolId)
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)->orWhere('reviewer2_ID', $reviewerId);
            })->exists();

        if (!$assigned) {
            return redirect()->route('iacuc-reviewer.protocol-assign')->with('error', 'Access denied.');
        }

        // Fetch existing form data if any
        $form = IacucProtocolReview::where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId) // Match your migration column name
            ->first();

        // Fetch Protocol info for the default values in the inputs
        $protocol = Protocol::with(['user', 'researchInformation'])
            ->where('protocol_ID', $protocolId)
            ->first();

        return view('iacuc-reviewer.forms.protocol-review-checklist', compact('form', 'protocol'));
    }

    public function iacucProtocolReviewChecklistStore(Request $request)
    {
        $reviewerId = Auth::user()->user_ID;
        $protocolId = $request->protocol_id;

        // 1. Update or Create the Checklist Entry
        // We match by protocol_ID and reviewer_ID
        $review = IacucProtocolReview::updateOrCreate(
            [
                'protocol_ID' => $protocolId,
                'reviewer_ID' => $reviewerId,
            ],
            [
                // Unique ID if your table uses a non-incrementing string ID
                'review_id' => (string) Str::uuid(), 
                
                // Fields from your Blade file
                'study_title' => $request->study_title,
                'pi_person'   => $request->pi_person,
                'adviser'     => $request->adviser,

                // Textareas: All Protocols
                'scientific_merit_comment'      => $request->scientific_merit_comment,
                'training_experience_comment'   => $request->training_experience_comment,
                'overview_section_comment'      => $request->overview_section_comment,
                'rational_justification_comment' => $request->rational_justification_comment,
                'adequate_justification_comment' => $request->adequate_justification_comment,
                'unnecessary_duplication_comment' => $request->unnecessary_duplication_comment,
                'experimental_procedures_comment' => $request->experimental_procedures_comment,
                'endpoint_duration_comment'     => $request->endpoint_duration_comment,
                'euthanasia_method_comment'     => $request->euthanasia_method_comment,
                'pain_category_comment'         => $request->pain_category_comment,
                'alternative_housing_comment'   => $request->alternative_housing_comment,

                // Textareas: As Applicable
                'hazardous_material_comment'    => $request->hazardous_material_comment,
                'multiple_survival_comment'     => $request->multiple_survival_comment,
                'pain_relief_comment'           => $request->pain_relief_comment,
                'ill_debilitated_comment'       => $request->ill_debilitated_comment,
                'complications_comment'         => $request->complications_comment,

                // Textareas: Veterinary Review
                'veterinary_complications_comment' => $request->veterinary_complications_comment,
                'proposed_anesthesia_comment'      => $request->proposed_anesthesia_comment,
                'post_procedural_comment'          => $request->post_procedural_comment,
                'appropriate_method_comment'       => $request->appropriate_method_comment,

                // Summary
                'summary_comments' => $request->summary_comments,
            ]
        );

        // 2. Log the process
        $this->logProcess('REV_IAC_SAVE', "Saved IACUC Protocol Checklist for: $protocolId", 'reviewer_iacuc', 'out', $reviewerId);

        return redirect()->back()->with('success', 'Protocol review checklist has been saved successfully.');
    }

    public function iacucSubmitForm(Request $request, $formId)
    {
        $reviewerId = Auth::user()->user_ID;

        // Validate uploaded files
        $request->validate([
            'uploadForms.*' => 'required|file|mimes:doc,docx,pdf|max:10240'
        ]);

        // Get protocol_id from request or from assignment
        $protocolId = $request->input('protocol_id');
        
        if (!$protocolId) {
            $assignedForm = InitialReview::where('form_id', $formId)
                ->where(function ($q) use ($reviewerId) {
                    $q->where('reviewer1_ID', $reviewerId)
                        ->orWhere('reviewer2_ID', $reviewerId);
                })
                ->first();

            if ($assignedForm) {
                $protocolId = $assignedForm->protocol_ID;
            }
        }

        if (!$protocolId) {
            return redirect()->back()->with('error', 'Unable to determine protocol for this submission.');
        }

        // ✅ YOU MISSED THIS - Get the form object
        $form = FormsTable::where('form_id', $formId)
            ->where('form_type', 'Submission')
            ->firstOrFail();

        // Verify if form is assigned to this reviewer
        $assignedForm = InitialReview::where('form_id', $formId)
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->first();

        if (!$assignedForm) {
            return redirect()->back()->with('error', 'This form is not assigned to you.');
        }

        // Check if reviewer has already submitted for this form AND protocol
        $existingSubmission = ReviewerFile::where('form_id', $formId)
            ->where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->exists();

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted documents for this form.');
        }

        // Save uploaded files under reviewer_files/{protocol_ID}/
        foreach ($request->file('uploadForms') as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->store("reviewer_files/{$protocolId}", 'public');

            ReviewerFile::create([
                'form_id' => $form->form_id,
                'protocol_ID' => $protocolId,
                'reviewer_ID' => $reviewerId,
                'file_name' => $filename,
                'file_path' => $path,
            ]);
        }

        /**
         * --- EVALUATION LOGIC ---
         * Always record in tbl_evaluated_reviews once any submission is made.
         * Mark as "In Progress" unless all Submission-type forms are done.
         */

        // All forms assigned to this reviewer for this protocol
        $assignedForms = InitialReview::where('protocol_ID', $protocolId)
            ->where(function ($q) use ($reviewerId) {
                $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->pluck('form_id')
            ->unique();

        // Get only Submission-type assigned forms
        $submissionFormIds = FormsTable::whereIn('form_id', $assignedForms)
            ->where('form_type', 'Submission')
            ->pluck('form_id');

        // Forms that reviewer has already submitted
        $submittedForms = ReviewerFile::where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->pluck('form_id')
            ->unique();

        // Determine progress
        $allSubmitted = $submissionFormIds->diff($submittedForms)->isEmpty();
        $status = $allSubmitted ? 'Completed' : 'In Progress';

        // Always record or update in tbl_evaluated_reviews
        EvaluatedReviews::updateOrCreate(
            [
                'protocol_ID' => $protocolId,
                'reviewer_ID' => $reviewerId
            ],
            [
                'status' => $status,
                'completed_at' => $allSubmitted ? now() : null
            ]
        );

        // ✅ PROCESS MONITORING: Reviewer Submits Forms (OUTGOING)
        ProcessMonitoring::create([
            'process_code' => 'REV_IAC3',
            'process_description' => 'Submit accomplished forms to IACUC admin for protocol: ' . $protocolId,
            'user_type' => 'reviewer_iacuc',
            'direction' => 'out',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => 'reviewer_iacuc',
            'affected_user_id' => null,
            'affected_user_type' => 'admin_iacuc',
        ]);

        // ✅ PROCESS MONITORING: IACUC Admin Receives Forms (INCOMING)
        ProcessMonitoring::create([
            'process_code' => 'IAC4',
            'process_description' => 'Received accomplished forms from reviewer for protocol: ' . $protocolId,
            'user_type' => 'admin_iacuc',
            'direction' => 'in',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => 'reviewer_iacuc',
            'affected_user_id' => null,
            'affected_user_type' => 'admin_iacuc',
        ]);

        // 🔹 NOTIFY IACUC ADMINS ABOUT REVIEWER PROGRESS
        $adminUsers = User::where('user_Access', 'IACUC Admin')->get();
        
        if ($adminUsers->isNotEmpty()) {
            foreach ($adminUsers as $admin) {
                $admin->notify(new ReviewerProgress($protocolId, $reviewerId, $status, $formId));

                ProcessMonitoring::create([
                    'process_code' => 'IAC4',
                    'process_description' => 'Reviewer progress notification: ' . $status . ' for protocol ' . $protocolId,
                    'user_type' => 'admin_iacuc',
                    'direction' => 'in',
                    'timestamp' => now(),
                    'action_by_user_id' => $reviewerId,
                    'action_by_user_type' => 'reviewer_iacuc',
                    'affected_user_id' => $admin->user_ID,
                    'affected_user_type' => 'admin_iacuc',
                ]);
            }
        }

        // 🔹 CHECK IF ALL REVIEWERS HAVE COMPLETED THEIR EVALUATIONS
        if ($status === 'Completed') {
            $this->iacucCheckAllReviewsCompleted($protocolId);
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    /**
     * Check if all reviewers have completed their evaluations for a protocol
     */
    private function iacucCheckAllReviewsCompleted($protocolId)
    {
        // Get all reviewers assigned to this protocol
        $assignedReviewers = InitialReview::where('protocol_ID', $protocolId)
            ->where(function ($q) {
                $q->whereNotNull('reviewer1_ID')
                ->orWhereNotNull('reviewer2_ID');
            })
            ->get();

        $reviewer1Ids = $assignedReviewers->pluck('reviewer1_ID')->filter()->unique();
        $reviewer2Ids = $assignedReviewers->pluck('reviewer2_ID')->filter()->unique();
        $allReviewerIds = $reviewer1Ids->merge($reviewer2Ids)->unique();

        // Check if all reviewers have completed their evaluations
        $completedReviews = EvaluatedReviews::where('protocol_ID', $protocolId)
            ->whereIn('reviewer_ID', $allReviewerIds)
            ->where('status', 'Completed')
            ->count();

        // If all reviewers have completed, notify the student
        if ($allReviewerIds->count() > 0 && $completedReviews === $allReviewerIds->count()) {
            $protocol = Protocol::where('protocol_ID', $protocolId)->first();
            
            if ($protocol) {
                $student = User::find($protocol->user_ID);
                $reviewType = $protocol->review_type;
                
                if ($student) {
                    $student->notify(new ReviewCompleted($protocolId, $reviewType));

                    // ✅ PROCESS MONITORING: PI Notified of Completed Review
                    // Use the system user or a default admin user ID instead of null
                    $systemUserId = User::where('user_Access', 'IACUC Admin')->first()->user_ID ?? 'system';
                    
                    ProcessMonitoring::create([
                        'process_code' => 'PI1',
                        'process_description' => 'All reviews completed for protocol: ' . $protocolId,
                        'user_type' => 'pi',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => $systemUserId, // Use actual user ID instead of null
                        'action_by_user_type' => 'system',
                        'affected_user_id' => $student->user_ID,
                        'affected_user_type' => 'pi',
                    ]);
                }
            }
        }
    }
    private function logProcess($code, $desc, $uType, $dir, $actorId, $affectedId = null, $affectedType = null)
    {
        ProcessMonitoring::create([
            'process_code' => $code,
            'process_description' => $desc,
            'user_type' => $uType,
            'direction' => $dir,
            'timestamp' => now(),
            'action_by_user_id' => $actorId,
            'action_by_user_type' => $uType,
            'affected_user_id' => $affectedId,
            'affected_user_type' => $affectedType,
        ]);
    }

        /**
     * Mark a single notification as read for IACUC reviewer
     */
    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            // Log the action
            $this->logProcess(
                'NOTIF_READ',
                "Notification marked as read: " . $notification->id,
                auth()->user()->user_Access === 'IACUC Reviewer' ? 'reviewer_iacuc' : 'reviewer_erb',
                'in',
                auth()->user()->user_ID
            );
        }
        
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read for IACUC reviewer
     */
    public function markAllNotificationsAsRead()
    {
        $unreadCount = auth()->user()->unreadNotifications->count();
        auth()->user()->unreadNotifications->markAsRead();
        
        // Log the action
        $this->logProcess(
            'NOTIF_ALL_READ',
            "All notifications marked as read. Total: " . $unreadCount,
            auth()->user()->user_Access === 'IACUC Reviewer' ? 'reviewer_iacuc' : 'reviewer_erb',
            'in',
            auth()->user()->user_ID
        );
        
        return back()->with('success', 'All notifications marked as read.');
    }

    public function iacucDashboard()
    {
        $reviewerId = auth()->user()->user_ID;
        
        $pendingProtocolsCount = DB::table('tbl_evaluated_reviews')
            ->where('reviewer_ID', $reviewerId)
            ->whereNotIn('status', ['Completed', 'Declined'])
            ->count();
            
        $evaluatedProtocolsCount = DB::table('tbl_evaluated_reviews')
            ->where('reviewer_ID', $reviewerId)
            ->where('status', 'Completed')
            ->count();
        
        return view('iacuc-reviewer.dashboard', compact(
            'pendingProtocolsCount', 
            'evaluatedProtocolsCount'
        ));
    }

    /**
 * Update IACUC review status (Accept/Decline)
 */
    public function iacucUpdateReviewStatus(Request $request)
    {
        $request->validate([
            'protocol_id' => 'required|string',
            'status' => 'required|in:Accepted,Declined',
            'decline_reason' => 'required_if:status,Declined|string|min:10|nullable'
        ]);

        $reviewerId = auth()->user()->user_ID;

        $review = EvaluatedReviews::where('protocol_ID', $request->protocol_id)
            ->where('reviewer_ID', $reviewerId)
            ->first();

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review record not found.'], 404);
        }

        // Update evaluated_reviews
        $review->update([
            'status' => $request->status,
            'decline_reason' => $request->status === 'Declined' ? $request->decline_reason : null,
            'completed_at' => $request->status === 'Accepted' ? null : now()
        ]);

        // Update initial_review when declined
        if ($request->status === 'Declined') {
            $initialReview = InitialReview::where('protocol_ID', $request->protocol_id)
                ->where(function($q) use ($reviewerId) {
                    $q->where('reviewer1_ID', $reviewerId)
                    ->orWhere('reviewer2_ID', $reviewerId);
                })
                ->first();

            if ($initialReview) {
                if ($initialReview->reviewer1_ID === $reviewerId) {
                    $initialReview->update(['reviewer1_ID' => null]);
                } elseif ($initialReview->reviewer2_ID === $reviewerId) {
                    $initialReview->update(['reviewer2_ID' => null]);
                }
                
                \Log::info("IACUC Reviewer {$reviewerId} cleared from protocol {$request->protocol_id}");
            }
        }

        // Process Monitoring
        ProcessMonitoring::create([
            'process_code' => $request->status === 'Accepted' ? 'REV_IAC_ACC' : 'REV_IAC_DEC',
            'process_description' => "Reviewer " . auth()->user()->user_Fname . " has " . strtolower($request->status) . " the review for protocol: " . $request->protocol_id . 
                ($request->status === 'Declined' ? " Reason: " . $request->decline_reason : ""),
            'user_type' => 'reviewer_iacuc',
            'direction' => 'out',
            'timestamp' => now(),
            'action_by_user_id' => $reviewerId,
            'action_by_user_type' => 'reviewer_iacuc',
        ]);

        return response()->json(['success' => true]);
    }
}