<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Protocol;
use App\Models\InitialReview;
use App\Models\EvaluatedReviews;
use App\Models\Approved;
use App\Models\ApprovedIacuc;
use App\Models\ResearchInformation;

class ERBDashboard extends Controller
{
    public function dashboard()
    {
        // Total users classified under ERB
        $totalUsers = User::where('user_Access', 'Principal Investigator')
            ->whereHas('classifications', function ($query) {
                $query->where('reviewClassification', 'ERB');
            })->count();

        // Pending users: PIs without assigned forms
        $pendingUsers = User::where('user_Access', 'Principal Investigator')
            ->doesntHave('forms')
            ->count();

        // Approved users: PIs with assigned forms
        $approvedUsers = User::where('user_Access', 'Principal Investigator')
            ->has('forms')
            ->count();

        // Research Protocol Counts
        // Total evaluated protocols (completed ones)
        $evaluatedProtocols = EvaluatedReviews::where('status', 'Completed')->count();

        // Protocols pending review (assigned but not evaluated)
        $pendingReviews = Protocol::whereHas('initialReviews')
            ->whereDoesntHave('evaluatedReviews', function($q) {
                $q->where('status', 'Completed');
            })
            ->count();

        // Ongoing reviews (protocols with initial review but not completed)
        $ongoingReviews = Protocol::whereHas('initialReviews')
            ->whereDoesntHave('evaluatedReviews', function($q) {
                $q->where('status', 'Completed');
            })
            ->count();

        // Approved protocols
        $approvedProtocols = Approved::where('Decision', 'Approved')->count();

        // Get recent protocols for the table with research information
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

                return [
                    'protocol_id' => $protocol->protocol_ID,
                    'research_title' => $researchTitle,
                    'reviewer' => $reviewerNames,
                    'status' => $status
                ];
            });

        return view('erb.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'approvedUsers',
            'evaluatedProtocols',
            'pendingReviews',
            'ongoingReviews',
            'approvedProtocols',
            'recentProtocols'
        ));
    }

    public function iacucDashboard()
    {
        // Total users classified under IACUC
        $totalUsers = User::where('user_Access', 'Principal Investigator')
            ->whereHas('classifications', function ($query) {
                $query->whereIn('reviewClassification', ['IACUC', 'BOTH']);
            })->count();

        // Pending users: PIs without assigned forms
        $pendingUsers = User::where('user_Access', 'Principal Investigator')
            ->whereHas('classifications', function ($query) {
                $query->whereIn('reviewClassification', ['IACUC', 'BOTH']);
            })
            ->doesntHave('forms')
            ->count();

        // Approved users: PIs with assigned forms
        $approvedUsers = User::where('user_Access', 'Principal Investigator')
            ->whereHas('classifications', function ($query) {
                $query->whereIn('reviewClassification', ['IACUC', 'BOTH']);
            })
            ->has('forms')
            ->count();

        // Research Protocol Counts for IACUC
        // Total evaluated protocols (completed ones) for IACUC
        $evaluatedProtocols = EvaluatedReviews::whereHas('protocol', function($query) {
                $query->where('protocol_ID', 'like', 'IACUC-%');
            })
            ->where('status', 'Completed')
            ->count();

        // Protocols pending review (assigned but not evaluated) for IACUC
        $pendingReviews = Protocol::where('protocol_ID', 'like', 'IACUC-%')
            ->whereHas('initialReviews')
            ->whereDoesntHave('evaluatedReviews', function($q) {
                $q->where('status', 'Completed');
            })
            ->count();

        // Ongoing reviews (protocols with initial review but not completed) for IACUC
        $ongoingReviews = Protocol::where('protocol_ID', 'like', 'IACUC-%')
            ->whereHas('initialReviews')
            ->whereDoesntHave('evaluatedReviews', function($q) {
                $q->where('status', 'Completed');
            })
            ->count();

        // Approved protocols for IACUC
        $approvedProtocols = ApprovedIacuc::where('Decision', 'Approved')->count();

        // Get recent IACUC protocols for the table with research information
        $recentProtocols = Protocol::with([
                'user', 
                'researchInformation',
                'initialReviews.reviewer1Info', 
                'initialReviews.reviewer2Info', 
                'evaluatedReviews'
            ])
            ->where('protocol_ID', 'like', 'IACUC-%')
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
                            $reviewers[] = $review->reviewer1Info->user_Fname . ' ' . $review->reviewer1Info->user_Lname;
                        }
                        if ($review->reviewer2Info) {
                            $reviewers[] = $review->reviewer2Info->user_Fname . ' ' . $review->reviewer2Info->user_Lname;
                        }
                    }
                }
                $reviewerNames = !empty($reviewers) ? implode(', ', array_unique($reviewers)) : 'Not assigned';

                // Determine status
                $status = 'Not reviewed';
                if ($protocol->evaluatedReviews && $protocol->evaluatedReviews->isNotEmpty()) {
                    $status = $protocol->evaluatedReviews->first()->status ?? 'Evaluated';
                } elseif ($protocol->initialReviews && $protocol->initialReviews->isNotEmpty()) {
                    $status = 'Ongoing Review';
                }

                return [
                    'protocol_id' => $protocol->protocol_ID,
                    'research_title' => $researchTitle,
                    'reviewer' => $reviewerNames,
                    'status' => $status
                ];
            });

        return view('iacuc.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'approvedUsers',
            'evaluatedProtocols',
            'pendingReviews',
            'ongoingReviews',
            'approvedProtocols',
            'recentProtocols'
        ));
    }
}