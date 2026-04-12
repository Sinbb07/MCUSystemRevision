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
        $erbReviewer = User::where('user_Access','ERB Reviewer')
            ->with('reviewerInformation')
            ->get();

        $piWithForms = User::with([
            'researchInformation', 
            'forms',
            'assignReviewer',
            'classifications' // Make sure to load classifications for filtering
        ])
        ->where('user_Access', 'Principal Investigator')
        ->whereHas('forms')
        ->whereHas('classifications', function ($q) {
            $q->whereIn('reviewClassification', ['ERB', 'BOTH']);
        })
        ->get()
        ->sortByDesc(function($user) {
            // Get the latest assignment date, or use a very old date if not assigned
            $latestAssignment = $user->assignReviewer->sortByDesc('created_at')->first();
            return $latestAssignment ? $latestAssignment->created_at : '1900-01-01';
        })
        ->values();
        
        $forms = FormsTable::whereIn('form_code', [
            'Form 2(E)',
            'Form 2(J)',
            'Upload FORM 2(E) Soft Copy',
            'Upload FORM 2(J) Soft Copy'
        ])->get();
        
        return view('erb.assign-reviewer', compact('piWithForms','erbReviewer','forms'));
    }

    public function iacucIndex(){
        $iacucReviewer = User::where('user_Access', 'IACUC Reviewer')
        ->with('reviewerInformation')
        ->get();

        $piWithIacuc = User::with([
            'researchInformation', 
            'assignReviewer',
            'classifications' // Make sure to load classifications for filtering
        ])
        ->where('user_Access', 'Principal Investigator')
        ->whereHas('classifications', function ($q) {
            $q->whereIn('reviewClassification', ['IACUC', 'BOTH']);
        })
        ->get()
        ->sortByDesc(function($user) {
            // Get the latest assignment date, or use a very old date if not assigned
            $latestAssignment = $user->assignReviewer->sortByDesc('created_at')->first();
            return $latestAssignment ? $latestAssignment->created_at : '1900-01-01';
        })
        ->values();

        return view('iacuc.assign-reviewer', compact('piWithIacuc', 'iacucReviewer'));
    }

    public function ERBstore(Request $request)
    {
        // ✅ Validate request
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

        $protocolCodes = [];
        $isExempted = $request->review_type === 'Exempted';

        foreach ($request->pis as $piID) {
            // 🔹 Generate Incremental Protocol Code
            $year = date('Y');
            $latestProtocol = Protocol::where('protocol_ID', 'like', "ERB-$year-%")
                ->orderBy('protocol_ID', 'desc')
                ->first();

            $nextNumber = $latestProtocol
                ? intval(substr($latestProtocol->protocol_ID, strrpos($latestProtocol->protocol_ID, '-') + 1)) + 1
                : 1;

            $protocolCode = sprintf("ERB-%s-%03d", $year, $nextNumber);
            $protocolCodes[] = $protocolCode;

            // 🔹 Save to tbl_protocol
            $protocol = Protocol::create([
                'protocol_ID' => $protocolCode,
                'user_ID' => $piID,
                'review_type' => $request->review_type,
            ]);

            // 🔹 Get PI (Student) details
            $piUser = User::find($piID);
            $piName = $piUser ? $piUser->user_Fname . ' ' . $piUser->user_Lname : 'Unknown';

            // ✅ ADDED PROCESS MONITORING: ERB Admin Assigns Reviewer (OUTGOING)
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

            // 🔹 Determine valid reviewers
            $reviewers = [
                'reviewer1' => $request->reviewer1_ID !== 'N/A' ? $request->reviewer1_ID : null,
                'reviewer2' => $request->reviewer2_ID !== 'N/A' ? $request->reviewer2_ID : null,
            ];

            // 🔹 Assign forms to initial review if at least one reviewer is valid AND review type is not exempted
            if (($reviewers['reviewer1'] || $reviewers['reviewer2']) && !$isExempted) {
                foreach ($request->assigned_forms as $formID) {
                    InitialReview::create([
                        'protocol_ID' => $protocol->protocol_ID,
                        'user_ID' => $piID,
                        'reviewer1_ID' => $reviewers['reviewer1'],
                        'reviewer2_ID' => $reviewers['reviewer2'],
                        'form_ID' => $formID,
                    ]);
                }
            }

            // 🔹 Create evaluated reviews for each valid reviewer
            foreach ($reviewers as $key => $reviewerID) {
                if ($reviewerID) {
                    EvaluatedReviews::create([
                        'protocol_ID' => $protocol->protocol_ID,
                        'reviewer_ID' => null,
                        'status' => 'Pending',
                        'completed_at' => now(),
                    ]);

                    // ✅ ADDED PROCESS MONITORING: Reviewer Receives Assignment (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'REV_ERB1',
                        'process_description' => 'Received forms and protocol from ERB admin: ' . $protocolCode,
                        'user_type' => 'reviewer_erb',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_erb',
                        'affected_user_id' => $reviewerID,
                        'affected_user_type' => 'reviewer_erb',
                    ]);

                    // 🔹 Notify Reviewer via Email and System Notification
                    $reviewer = User::find($reviewerID);
                    if ($reviewer && !empty($reviewer->user_Email)) {
                        // Send email notification
                        Mail::to($reviewer->user_Email)->queue(new NewProtocolAssignedMail($protocolCode, $piName, $request->review_type));
                        
                        // Send system notification
                        $reviewer->notify(new NewProtocolAssigned($protocolCode, $piName, $request->review_type));
                    }
                }
            }

            // 🔹 If both reviewers are "N/A", create a single evaluated review with null reviewer_ID
            if (!$reviewers['reviewer1'] && !$reviewers['reviewer2']) {
                EvaluatedReviews::create([
                    'protocol_ID' => $protocol->protocol_ID,
                    'reviewer_ID' => null,
                    'status' => 'Completed',
                    'completed_at' => now(),
                ]);

                // ✅ ADDED PROCESS MONITORING: Auto-completed with no reviewers
                ProcessMonitoring::create([
                    'process_code' => 'ERB10',
                    'process_description' => 'Decide protocol: ' . $protocolCode . ' (Auto-completed - No reviewers)',
                    'user_type' => 'admin_erb',
                    'direction' => 'out',
                    'timestamp' => now(),
                    'action_by_user_id' => auth()->user()->user_ID,
                    'action_by_user_type' => 'admin_erb',
                    'affected_user_id' => $piID,
                    'affected_user_type' => 'pi',
                ]);
            }

            // 🔹 Notify Student (PI) that their research is under review
            if ($piUser && !empty($piUser->user_Email)) {
                if ($isExempted) {
                    // For exempted protocols, notify about certificate
                    $research = $piUser->researchInformation;
                    Mail::to($piUser->user_Email)->queue(new CertificateExemptedMail($protocol, $piUser, $research));

                    // ✅ ADDED PROCESS MONITORING: Exempted Certificate
                    ProcessMonitoring::create([
                        'process_code' => 'ERB10',
                        'process_description' => 'Decide protocol: ' . $protocolCode . ' (Exempted)',
                        'user_type' => 'admin_erb',
                        'direction' => 'out',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_erb',
                        'affected_user_id' => $piID,
                        'affected_user_type' => 'pi',
                    ]);
                } else {
                    // For non-exempted protocols, notify about review process
                    Mail::to($piUser->user_Email)->queue(new ResearchUnderReviewMail($protocolCode, $request->review_type));

                    // ✅ ADDED PROCESS MONITORING: PI Notified Research Under Review
                    ProcessMonitoring::create([
                        'process_code' => 'PI1',
                        'process_description' => 'Research under review: ' . $protocolCode,
                        'user_type' => 'pi',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_erb',
                        'affected_user_id' => $piID,
                        'affected_user_type' => 'pi',
                    ]);
                }
                
                // Send system notification
                $piUser->notify(new ResearchUnderReview($protocolCode, $request->review_type));
            }
        }

        // 🔹 If exempted, generate PDF directly instead of redirecting
        if ($isExempted) {
            $protocol = Protocol::with('user', 'user.researchInformation')->where('protocol_ID', $protocolCodes[0])->first();
            
            if (!$protocol) {
                return response()->json(['error' => 'Protocol not found'], 404);
            }

            $data = [
                'date' => now()->format('F d, Y'),
                'protocol' => $protocol,
                'pi' => $protocol->user,
                'research' => $protocol->user->researchInformation,
            ];

            return Pdf::view('erb.forms.form2iPdf', $data)
                ->format('Letter')
                ->margins(15, 15, 15, 15)
                ->download("Exempted_Certificate_{$protocolCodes[0]}.pdf");
        }

        return response()->json(['message' => 'Reviewers successfully assigned!']);
    }

    public function IACUCstore(Request $request)
    {
        try {
            // ✅ Validate request
            $request->validate([
                'pis' => 'required|array',
                'pis.*' => 'required|string',
                'reviewer1_ID' => 'required|string',
                'reviewer2_ID' => 'required|string',
            ]);

            $protocolCodes = [];
            $reviewType = 'IACUC Review'; // Default review type

            // Check if we have any valid reviewers
            $hasValidReviewers = ($request->reviewer1_ID !== 'N/A' || $request->reviewer2_ID !== 'N/A');

            // 🔹 Use hardcoded form IDs for IACUC forms
            $iacucFormIds = [43, 44]; // PROTOCOL REVIEW CHECKLIST and Upload PROTOCOL REVIEW CHECKLIST

            foreach ($request->pis as $piID) {
                // 🔹 Generate Incremental Protocol Code
                $year = date('Y');
                $latestProtocol = Protocol::where('protocol_ID', 'like', "IACUC-$year-%")
                    ->orderBy('protocol_ID', 'desc')
                    ->first();

                $nextNumber = $latestProtocol
                    ? intval(substr($latestProtocol->protocol_ID, strrpos($latestProtocol->protocol_ID, '-') + 1)) + 1
                    : 1;

                $protocolCode = sprintf("IACUC-%s-%03d", $year, $nextNumber);
                $protocolCodes[] = $protocolCode;

                // 🔹 Save to tbl_protocol
                $protocol = Protocol::create([
                    'protocol_ID' => $protocolCode,
                    'user_ID' => $piID,
                    'review_type' => $reviewType,
                ]);

                // 🔹 Get PI details
                $piUser = User::find($piID);
                if (!$piUser) {
                    continue; // Skip if PI not found
                }
                
                $piName = $piUser->user_Fname . ' ' . $piUser->user_Lname;

                // ✅ PROCESS MONITORING: IACUC Admin Assigns Reviewer and Grants Ethical Clearance (OUTGOING)
                ProcessMonitoring::create([
                    'process_code' => 'IAC6',
                    'process_description' => 'Assign reviewer and grant ethical clearance for protocol: ' . $protocolCode,
                    'user_type' => 'admin_iacuc',
                    'direction' => 'out',
                    'timestamp' => now(),
                    'action_by_user_id' => auth()->user()->user_ID,
                    'action_by_user_type' => 'admin_iacuc',
                    'affected_user_id' => $piID,
                    'affected_user_type' => 'pi',
                ]);

                // 🔹 Determine valid reviewers
                $reviewers = [
                    'reviewer1' => $request->reviewer1_ID !== 'N/A' ? $request->reviewer1_ID : null,
                    'reviewer2' => $request->reviewer2_ID !== 'N/A' ? $request->reviewer2_ID : null,
                ];

                // 🔹 Assign forms to initial review if at least one reviewer is valid
                if ($hasValidReviewers) {
                    foreach ($iacucFormIds as $formId) {
                        InitialReview::create([
                            'protocol_ID' => $protocol->protocol_ID,
                            'user_ID' => $piID,
                            'reviewer1_ID' => $reviewers['reviewer1'],
                            'reviewer2_ID' => $reviewers['reviewer2'],
                            'form_ID' => $formId, // Use the actual form ID
                        ]);
                    }

                    // ✅ PROCESS MONITORING: Send evaluation forms to reviewer (OUTGOING)
                    ProcessMonitoring::create([
                        'process_code' => 'IAC8',
                        'process_description' => 'Send evaluation forms to reviewer for protocol: ' . $protocolCode,
                        'user_type' => 'admin_iacuc',
                        'direction' => 'out',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_iacuc',
                        'affected_user_id' => null, // Affects all assigned reviewers
                        'affected_user_type' => 'reviewer_iacuc',
                    ]);
                }

                // 🔹 Create evaluated reviews for each valid reviewer
                foreach ($reviewers as $reviewerID) {
                    if ($reviewerID) {
                        EvaluatedReviews::create([
                            'protocol_ID' => $protocol->protocol_ID,
                            'reviewer_ID' => $reviewerID,
                            'status' => 'Pending',
                            'completed_at' => null,
                        ]);

                        // ✅ PROCESS MONITORING: Reviewer Receives Forms and Protocol (INCOMING)
                        ProcessMonitoring::create([
                            'process_code' => 'REV_IAC1',
                            'process_description' => 'Received forms and protocol from IACUC admin: ' . $protocolCode,
                            'user_type' => 'reviewer_iacuc',
                            'direction' => 'in',
                            'timestamp' => now(),
                            'action_by_user_id' => auth()->user()->user_ID,
                            'action_by_user_type' => 'admin_iacuc',
                            'affected_user_id' => $reviewerID,
                            'affected_user_type' => 'reviewer_iacuc',
                        ]);

                        // 🔹 Notify Reviewer via Email and System Notification
                        $reviewer = User::find($reviewerID);
                        if ($reviewer && !empty($reviewer->user_Email)) {
                            // Send email notification
                            Mail::to($reviewer->user_Email)->queue(new NewProtocolAssignedMail($protocolCode, $piName, $reviewType));
                            
                            // Send system notification
                            $reviewer->notify(new NewProtocolAssigned($protocolCode, $piName, $reviewType));
                        }
                    }
                }

                // 🔹 If both reviewers are "N/A", create a single evaluated review with null reviewer_ID
                if (!$hasValidReviewers) {
                    EvaluatedReviews::create([
                        'protocol_ID' => $protocol->protocol_ID,
                        'reviewer_ID' => null,
                        'status' => 'Completed',
                        'completed_at' => now(),
                    ]);

                    // No IAC9 process monitoring - removed as requested
                }

                // 🔹 Notify Student (PI) that their research is under review
                if (!empty($piUser->user_Email)) {
                    // Notify about review process
                    Mail::to($piUser->user_Email)->queue(new ResearchUnderReviewMail($protocolCode, $reviewType));

                    // ✅ PROCESS MONITORING: PI Receives Approval (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'PI1',
                        'process_description' => 'Approval IRO (IACUC) - Research under review: ' . $protocolCode,
                        'user_type' => 'pi',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'admin_iacuc',
                        'affected_user_id' => $piID,
                        'affected_user_type' => 'pi',
                    ]);
                    
                    // Send system notification
                    $piUser->notify(new ResearchUnderReview($protocolCode, $reviewType));
                }
            }

            return response()->json(['message' => 'IACUC Reviewers successfully assigned and ethical clearance granted!']);

        } catch (\Exception $e) {
            \Log::error('IACUC Store Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to assign reviewers: ' . $e->getMessage()], 500);
        }
    }
}
