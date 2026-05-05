<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluatedReviews;
use App\Models\Approved;
use App\Models\FormUser;
use App\Models\FormsTable;
use App\Models\Protocol;
use App\Notifications\ProtocolDecision;
use App\Models\ProcessMonitoring;
use App\Models\ApprovedIacuc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ERBDecisionController extends Controller
{
    public function index()
    {
        // Get all protocol IDs that already have a decision in tbl_approved
        $approvedProtocolIds = Approved::pluck('Protocol_ID')->toArray();
        
        // Fetch one record per protocol (latest only) - EXCLUDING already approved ones
        $evaluatedProtocols = EvaluatedReviews::with([
            'protocol.researchInformation.user'
        ])
        ->whereHas('protocol', function($query) use ($approvedProtocolIds) {
            $query->where('protocol_ID', 'like', 'ERB-%')
                ->whereNotIn('protocol_ID', $approvedProtocolIds); // EXCLUDE already approved protocols
        })
        ->selectRaw('protocol_id, MAX(updated_at) as latest_review_date')
        ->groupBy('protocol_id')
        ->get()
        ->map(function ($item) {
            // Get the latest review for each protocol
            $latestReview = EvaluatedReviews::where('protocol_id', $item->protocol_id)
                ->orderByDesc('updated_at')
                ->with(['protocol.researchInformation.user'])
                ->first();

            $researchInfo = $latestReview->protocol->researchInformation ?? null;
            $user = $researchInfo?->user;

            return (object) [
                'protocol_ID'      => $latestReview->protocol->protocol_ID ?? 'N/A',
                'research_title'   => $researchInfo->research_title ?? 'N/A',
                'user_Fname'       => $user->user_Fname ?? 'N/A',
                'co_investigator'  => $researchInfo->research_CoInvestigator ?? 'N/A',
                'status'           => $latestReview->status ?? 'Pending',
                'date_submitted'   => $latestReview->created_at,
                'review_date'      => $latestReview->updated_at,
            ];
        });

        return view('erb.protocol-decision', compact('evaluatedProtocols'));
    }

    public function iacucIndex()
    {
        // Get all protocol IDs that already have a decision in tbl_approved_iacuc
        $approvedProtocolIds = ApprovedIacuc::pluck('Protocol_ID')->toArray();
        
        \Log::info('Approved IACUC Protocol IDs:', $approvedProtocolIds);
        
        // Fetch one record per protocol (latest only) for IACUC - EXCLUDING already approved ones
        $evaluatedProtocols = EvaluatedReviews::with([
            'protocol.researchInformation.user'
        ])
        ->whereHas('protocol', function($query) use ($approvedProtocolIds) {
            $query->where('protocol_ID', 'like', 'IACUC-%');
            
            // Only exclude if there are approved protocols
            if (!empty($approvedProtocolIds)) {
                $query->whereNotIn('protocol_ID', $approvedProtocolIds);
            }
        })
        ->selectRaw('protocol_id, MAX(updated_at) as latest_review_date')
        ->groupBy('protocol_id')
        ->get()
        ->map(function ($item) {
            $latestReview = EvaluatedReviews::where('protocol_id', $item->protocol_id)
                ->orderByDesc('updated_at')
                ->with(['protocol.researchInformation.user'])
                ->first();

            $researchInfo = $latestReview->protocol->researchInformation ?? null;
            $user = $researchInfo?->user;

            return (object) [
                'protocol_ID'      => $latestReview->protocol->protocol_ID ?? 'N/A',
                'research_title'   => $researchInfo->research_title ?? 'N/A',
                'user_Fname'       => $user->user_Fname ?? 'N/A',
                'user_Lname'       => $user->user_Lname ?? '',
                'co_investigator'  => $researchInfo->research_CoInvestigator ?? 'N/A',
                'status'           => $latestReview->status ?? 'Pending',
                'date_submitted'   => $latestReview->created_at,
                'review_date'      => $latestReview->updated_at,
            ];
        });

        return view('iacuc.protocol-decision', compact('evaluatedProtocols'));
    }

    public function iacucStoreDecision(Request $request)
    {
        try {
            \Log::info('IACUC Decision Request received:', $request->all());
            
            $request->validate([
                'protocol_id' => 'required|string',
                'decision' => 'required|string|in:Approved,Resubmission'
            ]);

            $protocolId = $request->protocol_id;
            $decision = $request->decision;

            // Verify the protocol exists and is IACUC
            $protocol = Protocol::where('protocol_ID', $protocolId)
                ->where('protocol_ID', 'like', 'IACUC-%')
                ->first();

            if (!$protocol) {
                \Log::error('Protocol not found: ' . $protocolId);
                return response()->json([
                    'success' => false,
                    'message' => 'Protocol not found: ' . $protocolId
                ], 404);
            }

            $userId = $protocol->user_ID;

            // Make sure the decision matches exactly what the enum expects
            // Allowed values: 'Approved' or 'Resubmission'
            $dbDecision = $decision; // Should already be 'Approved' or 'Resubmission'

            // Check if record already exists
            $existing = ApprovedIacuc::where('Protocol_ID', $protocolId)->first();
            
            if ($existing) {
                \Log::info('Updating existing record for protocol: ' . $protocolId);
                $existing->update([
                    'user_ID' => $userId,
                    'Decision' => $dbDecision
                ]);
            } else {
                \Log::info('Creating new record for protocol: ' . $protocolId);
                ApprovedIacuc::create([
                    'Protocol_ID' => $protocolId,
                    'user_ID' => $userId,
                    'Decision' => $dbDecision
                ]);
            }

            \Log::info('Successfully saved decision for protocol: ' . $protocolId);

            // Update protocol status
            $protocol->update([
                'status' => $dbDecision === 'Approved' ? 'Approved' : 'Resubmission'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Protocol ' . $protocolId . ' has been ' . strtolower($decision) . ' successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in IACUC Decision: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . json_encode($e->errors())
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in IACUC Decision: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            \Log::error('IACUC Decision Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save decision: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // ✅ Validate request
        $validated = $request->validate([
            'protocol_id' => 'required|string|exists:tbl_protocol,protocol_ID',
            'decision' => 'required|string|in:Approved,Resubmission',
        ]);

        try {
            $protocolId = $validated['protocol_id'];
            $decision = $validated['decision'];

            // ✅ Get protocol with PI relationship in single query
            $protocol = Protocol::with('researchInformation.user')
                ->where('protocol_ID', $protocolId)
                ->firstOrFail();

            if (!$protocol->researchInformation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Principal Investigator not found for this protocol.',
                ], 404);
            }

            $piUserId = $protocol->researchInformation->user_ID;

            // ✅ Store decision
            Approved::updateOrCreate(
                ['Protocol_ID' => $protocolId, 'user_ID' => $piUserId],
                ['Decision' => $decision]
            );

            // ✅ ADDED PROCESS MONITORING: ERB Admin Makes Decision (OUTGOING)
            ProcessMonitoring::create([
                'process_code' => 'ERB10',
                'process_description' => 'Decide protocol: ' . $protocolId . ' - ' . $decision,
                'user_type' => 'admin_erb',
                'direction' => 'out',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => $piUserId,
                'affected_user_type' => 'pi',
            ]);

            // ✅ ADDED PROCESS MONITORING: PI Receives Decision (INCOMING)
            ProcessMonitoring::create([
                'process_code' => 'PI1',
                'process_description' => 'Protocol decision: ' . $protocolId . ' - ' . $decision,
                'user_type' => 'pi',
                'direction' => 'in',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => $piUserId,
                'affected_user_type' => 'pi',
            ]);

            // ✅ Get form configuration
            $formConfig = $this->getFormConfiguration($decision);
            
            // ✅ Combine both assignment and submission forms for processing
            $allFormCodes = array_merge(
                array_keys($formConfig['assignment_forms']),
                array_keys($formConfig['submission_forms'])
            );
            
            // ✅ Preload all forms in single query
            $existingForms = FormsTable::whereIn('form_code', $allFormCodes)->get()->keyBy('form_code');
            
            // ✅ Assign all forms with validation
            $assignedForms = [];
            
            // Assign assignment forms
            foreach ($formConfig['assignment_forms'] as $formCode => $formName) {
                if ($form = $existingForms->get($formCode)) {
                    FormUser::updateOrCreate(
                        ['user_ID' => $piUserId, 'form_id' => $form->form_id]
                    );
                    $assignedForms[] = $formName;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Form {$formCode} not found in tbl_forms.",
                    ], 404);
                }
            }
            
            // Assign submission forms
            foreach ($formConfig['submission_forms'] as $formCode => $formName) {
                if ($form = $existingForms->get($formCode)) {
                    FormUser::updateOrCreate(
                        ['user_ID' => $piUserId, 'form_id' => $form->form_id]
                    );
                    $assignedForms[] = $formName;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Form {$formCode} not found in tbl_forms.",
                    ], 404);
                }
            }

            // ✅ ADDED PROCESS MONITORING: ERB Admin Assigns Forms Based on Decision (OUTGOING)
            ProcessMonitoring::create([
                'process_code' => 'ERB5',
                'process_description' => 'Assign forms to PI based on ' . $decision . ' decision: ' . implode(', ', $assignedForms),
                'user_type' => 'admin_erb',
                'direction' => 'out',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => $piUserId,
                'affected_user_type' => 'pi',
            ]);

            // ✅ ADDED PROCESS MONITORING: PI Receives Forms Based on Decision (INCOMING)
            ProcessMonitoring::create([
                'process_code' => 'PI2',
                'process_description' => 'Received forms from admin based on ' . $decision . ' decision: ' . implode(', ', $assignedForms),
                'user_type' => 'pi',
                'direction' => 'in',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => $piUserId,
                'affected_user_type' => 'pi',
            ]);

            // ✅ Notify student
            if ($protocol->researchInformation->user) {
                $protocol->researchInformation->user->notify(
                    new ProtocolDecision($protocolId, $decision, $assignedForms)
                );
            }

            return response()->json([
                'success' => true,
                'message' => $formConfig['success_message'],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Protocol not found.',
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Protocol decision error: ' . $e->getMessage(), [
                'protocol_id' => $protocolId ?? 'unknown',
                'decision' => $decision ?? 'unknown'
            ]);
            
            // ✅ ADDED PROCESS MONITORING: Protocol Decision Failed
            ProcessMonitoring::create([
                'process_code' => 'ERB10',
                'process_description' => 'Protocol decision failed: ' . $e->getMessage(),
                'user_type' => 'admin_erb',
                'direction' => 'out',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => null,
                'affected_user_type' => null,
                'metadata' => ['error' => $e->getMessage(), 'protocol_id' => $protocolId ?? 'unknown']
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Get form configuration based on decision
     */
    private function getFormConfiguration(string $decision): array
    {
        $configurations = [
            'Approved' => [
                'assignment_forms' => [
                    'FORM 3(L)' => 'FORM 3(L) - FINAL REPORTS',
                    'FORM 3(C)' => 'FORM 3(C) - PROGRESS REPORTS',
                ],
                'submission_forms' => [
                    'Final Thesis Manuscript' => 'Final Thesis Manuscript Submission',
                    'IMRAD format of Final Thesis' => 'IMRAD Format Submission',
                    'Plagiarism certification' => 'Plagiarism Certification Submission',
                    'Grammar certification' => 'Grammar Certification Submission',
                    'Upload FORM 3(L) Soft Copy' => 'FORM 3(L) Soft Copy Upload',
                    'Upload FORM 3(C) Soft Copy' => 'FORM 3(C) Soft Copy Upload',
                ],
                'success_message' => 'Protocol approved and all required forms assigned to the Principal Investigator.',
            ],
            'Resubmission' => [
                'assignment_forms' => [
                    'FORM 3(A)' => 'FORM 3(A) - RESUBMISSION',
                    'FORM 3(B)' => 'FORM 3(B) - REVIEW OF SUBMITTED STUDY PROTOCOL',
                ],
                'submission_forms' => [
                    'FORM 3(A) Soft Copy' => 'FORM 3(A) Soft Copy Submission',
                    'Upload FORM 3(B) Soft Copy' => 'FORM 3(B) Soft Copy Submission',
                    'MCUERB VERSION 2 DOCUMENTS' => 'MCUERB Version 2 Documents Submission',
                ],
                'success_message' => 'Resubmission recorded and all required forms assigned to the Principal Investigator.',
            ],
        ];

        return $configurations[$decision] ?? [
            'assignment_forms' => [],
            'submission_forms' => [],
            'success_message' => 'Decision recorded successfully.',
        ];
    }
    
        /**
     * Display resubmission records
     * Shows protocols that were marked as "Resubmission"
     */
    public function resubmission()
    {
        $approvedProtocols = Approved::with(['user', 'protocol.researchInformation'])
            ->where('Decision', 'Resubmission')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('erb.resubmission', compact('approvedProtocols'));
    }

    /**
     * Display final completion records
     * Shows protocols that were marked as "Approved"
     */
    public function finalCompletion()
    {
        $approvedProtocols = Approved::with(['user', 'protocol.researchInformation'])
            ->where('Decision', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        // Transform to match the view's expected variable name
        $principalInvestigators = [];
        
        foreach ($approvedProtocols as $approved) {
            $user = $approved->user;
            $protocol = $approved->protocol;
            $researchInfo = $protocol->researchInformation ?? null;
            
            if ($user && $researchInfo) {
                $user->protocol = $protocol;
                $user->researchInformation = $researchInfo;
                $user->status = 'Completed'; // Since it's approved
                $principalInvestigators[] = $user;
            }
        }

        return view('erb.final-completion', compact('principalInvestigators'));
    }

}
