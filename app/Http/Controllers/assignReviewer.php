<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Protocol;
use App\Models\InitialReview;
use App\Models\FormsTable;
use App\Models\EvaluatedReviews;
use Illuminate\Validation\Rule;
use App\Notifications\NewProtocolAssigned;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Notifications\ResearchUnderReview;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateExemptedMail;
use App\Mail\ResearchUnderReviewMail;
use App\Mail\NewProtocolAssignedMail;
use App\Models\ProcessMonitoring;

class assignReviewer extends Controller
{
    public function index()
    {
        $erbReviewer = User::where('user_Access', 'ERB Reviewer')
            ->with('reviewerInformation')
            ->get();

        $piWithForms = User::with([
                'researchInformation', 
                'forms',
                'protocol.evaluatedReviews.reviewer', // 👈 Add this to catch declined reviews
                'classifications'
            ])
            ->where('user_Access', 'Principal Investigator')
            ->whereHas('forms')
            ->whereHas('classifications', function ($q) {
                $q->whereIn('reviewClassification', ['ERB', 'BOTH']);
            })
            ->get()
            ->filter(function($user) {
                // Case 1: PI has forms but no protocol yet (New)
                if (!$user->protocol) return true;
                
                // Case 2: PI has a protocol but it was declined (Re-assignment)
                return $user->protocol->evaluatedReviews->contains('status', 'Declined');
            })
            ->sortByDesc(function($user) {
                $latestAssignment = $user->protocol ? $user->protocol->created_at : '1900-01-01';
                return $latestAssignment;
            })
            ->values();
        
        $forms = FormsTable::whereIn('form_code', [
            'Form 2(E)', 'Form 2(J)', 'Upload FORM 2(E) Soft Copy', 'Upload FORM 2(J) Soft Copy'
        ])->get();
        
        return view('erb.assign-reviewer', compact('piWithForms','erbReviewer','forms'));
    }

    public function iacucIndex() {
        $iacucReviewer = User::where('user_Access', 'IACUC Reviewer')
            ->with('reviewerInformation')->get();

        $piWithIacuc = User::with([
                'researchInformation', 
                'protocol.evaluatedReviews.reviewer' // 👈 Add '.reviewer' here
            ])
            ->where('user_Access', 'Principal Investigator')
            ->whereHas('classifications', function ($q) {
                $q->whereIn('reviewClassification', ['IACUC', 'BOTH']);
            })
            ->get()
            ->filter(function($user) {
                if (!$user->protocol) return true;
                return $user->protocol->evaluatedReviews->contains('status', 'Declined');
            });

        return view('iacuc.assign-reviewer', compact('piWithIacuc', 'iacucReviewer'));
    }

    public function ERBstore(Request $request)
    {
        $request->validate([
            'pis' => 'required|array',
            'review_type' => 'required|string',
            'reviewer1_ID' => 'required|string',
            'reviewer2_ID' => 'required|string',
            'assigned_forms' => [
                'array',
                Rule::requiredIf(function () use ($request) {
                    return ($request->reviewer1_ID !== 'N/A' || $request->reviewer2_ID !== 'N/A') 
                        && $request->review_type !== 'Exempted';
                }),
            ],
        ]);

        $isExempted = $request->review_type === 'Exempted';
        $protocolCodes = [];

        foreach ($request->pis as $piID) {
            $existingProtocol = Protocol::where('user_ID', $piID)
                ->where('protocol_ID', 'like', 'ERB%')
                ->first();

            if ($existingProtocol) {
                // --- RE-ASSIGNMENT ---
                $this->handleReassignment($existingProtocol, $request, $piID);
                $protocolCodes[] = $existingProtocol->protocol_ID;
            } else {
                // --- NEW ASSIGNMENT ---
                $year = date('Y');
                $latestProtocol = Protocol::where('protocol_ID', 'like', "ERB-$year-%")
                    ->orderBy('protocol_ID', 'desc')
                    ->first();

                $nextNumber = $latestProtocol
                    ? intval(substr($latestProtocol->protocol_ID, strrpos($latestProtocol->protocol_ID, '-') + 1)) + 1
                    : 1;

                $protocolCode = sprintf("ERB-%s-%03d", $year, $nextNumber);
                $protocolCodes[] = $protocolCode;

                $protocol = Protocol::create([
                    'protocol_ID' => $protocolCode,
                    'user_ID' => $piID,
                    'review_type' => $request->review_type,
                ]);

                $piUser = User::find($piID);
                $piName = $piUser ? $piUser->user_Fname . ' ' . $piUser->user_Lname : 'Unknown';

                // Monitor Admin Action
                ProcessMonitoring::create([
                    'process_code' => 'ERB6',
                    'process_description' => 'Assign reviewer for protocol: ' . $protocolCode,
                    'user_type' => 'admin_erb',
                    'direction' => 'out',
                    'timestamp' => now(),
                    'action_by_user_id' => auth()->user()->user_ID,
                    'action_by_user_type' => 'admin_erb',
                    'affected_user_id' => $piID,
                    'affected_user_type' => 'pi',
                ]);

                $reviewers = [
                    $request->reviewer1_ID !== 'N/A' ? $request->reviewer1_ID : null,
                    $request->reviewer2_ID !== 'N/A' ? $request->reviewer2_ID : null,
                ];

                // Assign forms to initial_review
                if (array_filter($reviewers) && !$isExempted) {
                    foreach ($request->assigned_forms as $formID) {
                        InitialReview::create([
                            'protocol_ID' => $protocolCode,
                            'user_ID' => $piID,
                            'reviewer1_ID' => $reviewers[0],
                            'reviewer2_ID' => $reviewers[1],
                            'form_ID' => $formID,
                        ]);
                    }
                }

                // Handle Reviewer Records & Notifications
                $hasReviewer = false;
                foreach ($reviewers as $reviewerID) {
                    if ($reviewerID) {
                        $hasReviewer = true;
                        EvaluatedReviews::create([
                            'protocol_ID' => $protocolCode,
                            'reviewer_ID' => $reviewerID,
                            'status' => 'Pending',
                        ]);

                        $reviewer = User::find($reviewerID);
                        if ($reviewer && !empty($reviewer->user_Email)) {
                            Mail::to($reviewer->user_Email)->queue(new NewProtocolAssignedMail($protocolCode, $piName, $request->review_type));
                            $reviewer->notify(new NewProtocolAssigned($protocolCode, $piName, $request->review_type));
                        }
                    }
                }

                // If no reviewers (Auto-Complete logic for Exempted/N/A)
                if (!$hasReviewer) {
                    EvaluatedReviews::create([
                        'protocol_ID' => $protocolCode,
                        'reviewer_ID' => null,
                        'status' => 'Completed',
                        'completed_at' => now(),
                    ]);
                }

                // Notify PI
                if ($piUser && !empty($piUser->user_Email)) {
                    if ($isExempted) {
                        Mail::to($piUser->user_Email)->queue(new CertificateExemptedMail($protocol, $piUser, $piUser->researchInformation));
                    } else {
                        Mail::to($piUser->user_Email)->queue(new ResearchUnderReviewMail($protocolCode, $request->review_type));
                    }
                    $piUser->notify(new ResearchUnderReview($protocolCode, $request->review_type));
                }
            }
        }

        // PDF Generation for Exempted
        if ($isExempted && !empty($protocolCodes)) {
            $protocol = Protocol::with('user', 'user.researchInformation')->where('protocol_ID', $protocolCodes[0])->first();
            $data = [
                'date' => now()->format('F d, Y'),
                'protocol' => $protocol,
                'pi' => $protocol->user,
                'research' => $protocol->user->researchInformation,
            ];
            return Pdf::view('erb.forms.form2iPdf', $data)->format('Letter')->margins(15, 15, 15, 15)->download("Exempted_Certificate_{$protocolCodes[0]}.pdf");
        }

        return response()->json(['message' => 'Reviewers successfully assigned/re-assigned!']);
    }
    public function IACUCstore(Request $request)
    {
        try {
            $request->validate([
                'pis' => 'required|array',
                'pis.*' => 'required|string',
                'reviewer1_ID' => 'required|string',
                'reviewer2_ID' => 'required|string',
            ]);

            $iacucFormIds = [43, 44]; 
            $reviewType = 'IACUC Review';
            $hasValidReviewers = ($request->reviewer1_ID !== 'N/A' || $request->reviewer2_ID !== 'N/A');

            foreach ($request->pis as $piID) {
                // 1. Check if a protocol already exists for this PI
                $existingProtocol = Protocol::where('user_ID', $piID)
                    ->where('protocol_ID', 'like', 'IACUC%')
                    ->first();

                if ($existingProtocol) {
                    $this->handleReassignment($existingProtocol, $request, $piID);
                } else {
                    // --- NEW ASSIGNMENT LOGIC ---
                    $year = date('Y');
                    $latestProtocol = Protocol::where('protocol_ID', 'like', "IACUC-$year-%")
                        ->orderBy('protocol_ID', 'desc')
                        ->lockForUpdate() // Add this to prevent race conditions
                        ->first();
                    $nextNumber = $latestProtocol ? intval(substr($latestProtocol->protocol_ID, strrpos($latestProtocol->protocol_ID, '-') + 1)) + 1 : 1;
                    $protocolCode = sprintf("IACUC-%s-%03d", $year, $nextNumber);

                    $protocol = Protocol::create([
                        'protocol_ID' => $protocolCode,
                        'user_ID' => $piID,
                        'review_type' => $reviewType,
                    ]);

                    $piUser = User::find($piID);
                    $piName = $piUser ? $piUser->user_Fname . ' ' . $piUser->user_Lname : 'Unknown';

                    // Process Monitoring for PI
                    ProcessMonitoring::create([
                        'process_code' => 'IAC6',
                        'process_description' => 'Assign reviewer for protocol: ' . $protocolCode,
                        'user_type' => 'admin_iacuc',
                        'direction' => 'out',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_iacuc',
                        'affected_user_id' => $piID,
                        'affected_user_type' => 'pi',
                    ]);

                    $reviewers = [
                        $request->reviewer1_ID !== 'N/A' ? $request->reviewer1_ID : null,
                        $request->reviewer2_ID !== 'N/A' ? $request->reviewer2_ID : null,
                    ];

                    // Assign Forms to tbl_initial_review
                    if ($hasValidReviewers) {
                        foreach ($iacucFormIds as $formId) {
                            InitialReview::create([
                                'protocol_ID' => $protocolCode,
                                'user_ID' => $piID,
                                'reviewer1_ID' => $reviewers[0],
                                'reviewer2_ID' => $reviewers[1],
                                'form_ID' => $formId,
                            ]);
                        }
                    }

                    // Create records in tbl_evaluated_reviews
                    foreach ($reviewers as $reviewerID) {
                        if ($reviewerID) {
                            EvaluatedReviews::create([
                                'protocol_ID' => $protocolCode,
                                'reviewer_ID' => $reviewerID,
                                'status' => 'Pending',
                            ]);

                            // Notify and Monitor Reviewer
                            $reviewer = User::find($reviewerID);
                            if ($reviewer) {
                                if (!empty($reviewer->user_Email)) {
                                    Mail::to($reviewer->user_Email)->queue(new NewProtocolAssignedMail($protocolCode, $piName, $reviewType));
                                    $reviewer->notify(new NewProtocolAssigned($protocolCode, $piName, $reviewType));
                                }
                                ProcessMonitoring::create([
                                    'process_code' => 'REV_IAC1',
                                    'process_description' => 'Received protocol: ' . $protocolCode,
                                    'user_type' => 'reviewer_iacuc',
                                    'direction' => 'in',
                                    'timestamp' => now(),
                                    'action_by_user_id' => auth()->user()->user_ID,
                                    'affected_user_id' => $reviewerID,
                                    'affected_user_type' => 'reviewer_iacuc',
                                ]);
                            }
                        }
                    }

                    // Final PI Notification
                    if ($piUser && !empty($piUser->user_Email)) {
                        Mail::to($piUser->user_Email)->queue(new ResearchUnderReviewMail($protocolCode, $reviewType));
                        $piUser->notify(new ResearchUnderReview($protocolCode, $reviewType));
                    }
                }
            }

            return response()->json(['message' => 'Assignments processed successfully!']);

        } catch (\Exception $e) {
            \Log::error('IACUC Store Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed: ' . $e->getMessage()], 500);
        }
    }

    private function handleReassignment($protocol, $request, $piID)
    {
        $protocolCode = $protocol->protocol_ID;
        $piUser = User::find($piID);
        $piName = $piUser ? $piUser->user_Fname . ' ' . $piUser->user_Lname : 'PI';
        $reviewType = str_starts_with($protocolCode, 'ERB') ? 'ERB Review' : 'IACUC Review';

        $declinedReviews = EvaluatedReviews::where('protocol_ID', $protocolCode)
            ->where('status', 'Declined')
            ->get();

        foreach ($declinedReviews as $index => $oldReview) {
            $newReviewerID = ($index == 0) ? $request->reviewer1_ID : $request->reviewer2_ID;

            if ($newReviewerID && $newReviewerID !== 'N/A') {
                $oldReviewerID = $oldReview->reviewer_ID;

                InitialReview::where('protocol_ID', $protocolCode)
                    ->where('reviewer1_ID', $oldReviewerID)
                    ->update(['reviewer1_ID' => $newReviewerID]);

                InitialReview::where('protocol_ID', $protocolCode)
                    ->where('reviewer2_ID', $oldReviewerID)
                    ->update(['reviewer2_ID' => $newReviewerID]);

                $oldReview->update(['reviewer_ID' => $newReviewerID, 'status' => 'Pending', 'completed_at' => null]);

                $newReviewer = User::find($newReviewerID);
                if ($newReviewer && !empty($newReviewer->user_Email)) {
                    Mail::to($newReviewer->user_Email)->queue(new NewProtocolAssignedMail($protocolCode, $piName, $reviewType));
                    $newReviewer->notify(new NewProtocolAssigned($protocolCode, $piName, $reviewType));
                }
            }
        }
    }
}