<?php

namespace App\Http\Controllers;

use App\Models\Protocol;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FullBoardModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FullBoardAssignedMail;
use App\Notifications\FullBoardAssignedNotification;
use App\Models\ProcessMonitoring;

class FullBoardReview extends Controller
{
    public function index()
    {
        $protocols = Protocol::where('review_type', 'Full Board')
        ->with([
            'user', 
            'researchInformation',
            'fullBoardAssignments.reviewer'
        ])
        ->get();

        // Fetch users with ERB Reviewers role
        $reviewers = User::where('user_Access', 'ERB Reviewer')
            ->get(['user_ID', 'user_Fname', 'user_Lname', 'user_MI']);

        return view('erb.full-board-review', compact('protocols', 'reviewers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'protocols' => 'required|array',
            'protocols.*' => 'exists:tbl_protocol,protocol_ID',
            'reviewers' => 'required|array',
            'reviewers.*' => 'exists:tbl_users,user_ID',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $assignedBy = auth()->user();
                
                foreach ($request->protocols as $protocolId) {
                    foreach ($request->reviewers as $reviewerId) {
                        // Generate unique assignment ID
                        $assignmentId = 'FBA-' . uniqid();
                        
                        FullBoardModel::create([
                            'assignment_ID' => $assignmentId,
                            'protocol_ID' => $protocolId,
                            'reviewer_ID' => $reviewerId,
                            'assigned_by' => $assignedBy->user_ID,
                        ]);

                        // ✅ ADDED PROCESS MONITORING: ERB Admin Assigns Full Board (OUTGOING)
                        ProcessMonitoring::create([
                            'process_code' => 'ERB7',
                            'process_description' => 'Assign fullboard reviewers for protocol: ' . $protocolId,
                            'user_type' => 'admin_erb',
                            'direction' => 'out',
                            'timestamp' => now(),
                            'action_by_user_id' => $assignedBy->user_ID,
                            'action_by_user_type' => 'admin_erb',
                            'affected_user_id' => $reviewerId,
                            'affected_user_type' => 'reviewer_erb',
                        ]);

                        // ✅ ADDED PROCESS MONITORING: Reviewer Receives Full Board Invitation (INCOMING)
                        ProcessMonitoring::create([
                            'process_code' => 'REV_ERB3',
                            'process_description' => 'Received full board invitation for protocol: ' . $protocolId,
                            'user_type' => 'reviewer_erb',
                            'direction' => 'in',
                            'timestamp' => now(),
                            'action_by_user_id' => $assignedBy->user_ID,
                            'action_by_user_type' => 'admin_erb',
                            'affected_user_id' => $reviewerId,
                            'affected_user_type' => 'reviewer_erb',
                        ]);

                        // Get reviewer details
                        $reviewer = User::find($reviewerId);
                        
                        // Send notifications if reviewer exists and has email
                        if ($reviewer) {
                            // Send system notification
                            $reviewer->notify(new FullBoardAssignedNotification($protocolId, $assignmentId, $assignedBy));
                            
                            // Send email notification
                            if (!empty($reviewer->user_Email)) {
                                Mail::to($reviewer->user_Email)->queue(new FullBoardAssignedMail($protocolId, $assignmentId, $assignedBy));
                            }
                        }
                    }
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Reviewers assigned successfully for full board review.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to assign full board reviewers: ' . $e->getMessage());
            
            // ✅ ADDED PROCESS MONITORING: Full Board Assignment Failed
            ProcessMonitoring::create([
                'process_code' => 'ERB7',
                'process_description' => 'Assign fullboard reviewers failed: ' . $e->getMessage(),
                'user_type' => 'admin_erb',
                'direction' => 'out',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'admin_erb',
                'affected_user_id' => null,
                'affected_user_type' => null,
                'metadata' => ['error' => $e->getMessage()]
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign reviewers: ' . $e->getMessage()
            ], 500);
        }
    }
}
