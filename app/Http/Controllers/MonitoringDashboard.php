<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchInformation;
use App\Models\FormsTable;
use App\Models\ResearchFiles;
use App\Models\Protocol;
use App\Models\Approved;
use App\Models\EvaluatedReviews;
use App\Models\User;
class MonitoringDashboard extends Controller
{
    public function index(){
        $monitor = User::with(['forms','researchInformation','classifications'])
        ->where('user_Access', 'Principal Investigator')   
        ->get();

        return view('superadmin.monitoring', compact('monitor'));
    }
    public function superadminResearchRecords()
    {
        $Records = ResearchInformation::with([
            // Load the P.I. user and their related data
            'user' => function ($query) {
                $query->with([
                    // Load all initial reviews and reviewers
                    'initialReviews' => function ($q) {
                        $q->with([
                            'protocol',        // Load protocol info
                            'reviewer1',       // Load reviewer 1 details
                            'reviewer2',       // Load reviewer 2 details
                        ]);
                    },
                    // Load approved decisions
                    'approved'
                ]);
            },
        ])->get();

        return view('superadmin.research-records', compact('Records'));
    }

    public function viewUnassignedReviewer(){
        $piWithForms = User::with(['researchInformation', 'forms'])
            ->where('user_Access', 'Principal Investigator')
            ->whereHas('forms')
            ->whereDoesntHave('protocol')
            ->get();

        return view('superadmin.assign-reviewer', compact('piWithForms'));
    }
    
    public function viewEvaluatedProtocols(){
        $evaluatedProtocols = EvaluatedReviews::with([
            'protocol.researchInformation.user'
        ])
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

        return view('superadmin.protocol-decision', compact('evaluatedProtocols'));
    }

    public function viewReviews()
    {
        $evaluatedReviews = EvaluatedReviews::with([
            'reviewer',
            'protocol.researchInformation.user',
        ])
        ->whereHas('protocol', function($query) {
            $query->where('protocol_ID', 'like', 'ERB-%')
                ->orWhere('protocol_ID', 'like', 'IACUC-%');
        })
        ->latest()
        ->get();

        return view('superadmin.view-reviews', compact('evaluatedReviews'));
    }
    public function viewFullBoard()
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

        return view('superadmin.full-board-review', compact('protocols', 'reviewers'));
    }
    public function viewFinalCompletion()
    {
        // Form IDs for final completion
        $finalCompletionFormIds = [37, 38, 39, 40, 41, 42];
        
        // Get Principal Investigators who have records in tbl_approved
        $principalInvestigators = User::where('user_Access', 'Principal Investigator')
            ->whereHas('Approved') // Only users with records in tbl_approved
            ->with([
                'researchInformation', 
                'protocol',
                'approved',
                'researchFiles' => function($query) use ($finalCompletionFormIds) {
                    $query->whereIn('form_id', $finalCompletionFormIds)
                          ->active();
                }
            ])
            ->get()
            ->map(function($investigator) use ($finalCompletionFormIds) {
                // Count submitted forms
                $submittedFormsCount = $investigator->researchFiles
                    ->whereIn('form_id', $finalCompletionFormIds)
                    ->count();
                
                // Simple status: Completed if all 6 forms submitted, otherwise Pending
                $investigator->status = $submittedFormsCount === count($finalCompletionFormIds) 
                    ? 'Completed' 
                    : 'Pending';
                
                return $investigator;
            });

        return view('superadmin.final-completion', compact('principalInvestigators'));
    }
    public function dashboard()
    {
        // Total assigned protocols
        $totalAssignedProtocols = Protocol::count();

        // Protocols that haven't been assigned a reviewer
        $protocolsWithoutReviewer = Protocol::whereDoesntHave('initialReviews')->count();

        // Total ongoing reviews
        // Protocols that have at least one initial review assigned
        // but have not yet been fully evaluated
        $ongoingReviews = Protocol::whereHas('initialReviews')
            ->whereDoesntHave('evaluatedReviews', function($q) {
                $q->where('status', 'Completed'); // only consider completed evaluations
            })
            ->count();

        // Total evaluated reviews (completed ones)
        $evaluatedReviews = EvaluatedReviews::where('status', 'Completed')->count();

        // Total approved protocols (Decision = 'Approved')
        $approvedProtocols = Approved::where('Decision', 'Approved')->count();

        // ✅ ADDED: Recent Protocols with detailed information
        $recentProtocols = Protocol::with([
                'user', 
                'researchInformation',
                'initialReviews.reviewer1Info', 
                'initialReviews.reviewer2Info', 
                'evaluatedReviews'
            ])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($protocol) {
                // Get research title from research information
                $researchTitle = 'No research title';
                if ($protocol->researchInformation) {
                    $researchTitle = $protocol->researchInformation->research_title ?? 'No research title';
                }

                // Get reviewer names
                $reviewers = [];
                if ($protocol->initialReviews) {
                    foreach ($protocol->initialReviews as $review) {
                        if ($review->reviewer1Info) {
                            $reviewers[] = $review->reviewer1Info->name ?? 'N/A';
                        }
                        if ($review->reviewer2Info) {
                            $reviewers[] = $review->reviewer2Info->name ?? 'N/A';
                        }
                    }
                }
                $reviewerNames = !empty($reviewers) ? implode(', ', array_unique($reviewers)) : 'Not assigned';

                // Determine status
                $status = 'Not reviewed';
                if ($protocol->evaluatedReviews && $protocol->evaluatedReviews->isNotEmpty()) {
                    $status = 'Evaluated';
                } elseif ($protocol->initialReviews && $protocol->initialReviews->isNotEmpty()) {
                    $status = 'Ongoing Review';
                }

                // Get PI Name
                $piName = 'N/A';
                if ($protocol->user) {
                    $piName = $protocol->user->user_Fname . ' ' . $protocol->user->user_Lname;
                }

                // Get submission date
                $submissionDate = $protocol->created_at ? $protocol->created_at->format('M d, Y') : 'N/A';

                return [
                    'protocol_id' => $protocol->protocol_ID,
                    'research_title' => $researchTitle,
                    'pi_name' => $piName,
                    'reviewer' => $reviewerNames,
                    'status' => $status,
                    'submission_date' => $submissionDate,
                    'protocol' => $protocol // Include the full protocol object if needed
                ];
            });

        return view('superadmin.dashboard', compact(
            'totalAssignedProtocols',
            'protocolsWithoutReviewer',
            'ongoingReviews',
            'evaluatedReviews',
            'approvedProtocols',
            'recentProtocols' // ✅ ADDED: Recent protocols
        ));
    }
}
