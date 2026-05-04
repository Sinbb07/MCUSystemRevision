<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessMonitoring;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProcessMonitoringController extends Controller
{
    public function index()
    {
        $processes = ProcessMonitoring::with(['actionBy.researchInformation', 'affectedUser.researchInformation'])
        ->orderBy('timestamp', 'desc')
        ->get()
        ->map(function ($process) {
            // For OUTGOING actions, show the action_by user (who sent it)
            // For INCOMING actions, show the affected user (who received it)
            if ($process->direction === 'out') {
                $displayUser = $process->actionBy; // Who performed the action
            } else {
                $displayUser = $process->affectedUser; // Who received the action
            }
            
            return [
                'pi_name' => $displayUser ? $displayUser->user_Fname . ' ' . $displayUser->user_Lname : 'System',
                'research_title' => $displayUser && $displayUser->researchInformation ? 
                    $displayUser->researchInformation->research_title : 'N/A',
                'account_type' => $displayUser ? $displayUser->user_Access : 'System',
                'date' => $process->timestamp->format('m/d/Y'),
                'time' => $process->timestamp->format('h:i:s A'),
                'description' => $process->process_description,
            ];
        });

        return view('superadmin.monitoring-process', compact('processes'));
    }

    public function erbindex()
    {
        $processes = ProcessMonitoring::with([
            'actionBy.researchInformation', 
            'affectedUser.researchInformation',
            'actionBy.classifications',
            'affectedUser.classifications'
        ])
        ->where(function($query) {
            $query->where('user_type', 'admin_erb')
                ->orWhere('user_type', 'reviewer_erb')
                ->orWhere(function($q) {
                    $q->where('user_type', 'pi')
                        ->where(function($subq) {
                            $subq->whereHas('actionBy', function($userQ) {
                                $userQ->whereHas('classifications', function($classQ) {
                                    $classQ->where('reviewClassification', 'ERB');
                                });
                            })
                            ->orWhereHas('affectedUser', function($userQ) {
                                $userQ->whereHas('classifications', function($classQ) {
                                    $classQ->where('reviewClassification', 'ERB');
                                });
                            });
                        });
                })
                ->orWhere('process_code', 'LIKE', 'ERB%')
                ->orWhere('process_code', 'LIKE', 'REV_ERB%')
                ->orWhere('process_code', 'LIKE', 'PI%');
        })
        ->orderBy('timestamp', 'desc')
        ->get()
        ->map(function ($process) {
            if ($process->direction === 'out') {
                $displayUser = $process->actionBy;
            } else {
                $displayUser = $process->affectedUser;
            }
            
            return [
                'pi_name' => $displayUser ? $displayUser->user_Fname . ' ' . $displayUser->user_Lname : 'System',
                'research_title' => $displayUser && $displayUser->researchInformation ? 
                    $displayUser->researchInformation->research_title : 'N/A',
                'account_type' => $displayUser ? $displayUser->user_Access : 'System',
                'date' => $process->timestamp->format('m/d/Y'),
                'time' => $process->timestamp->format('h:i:s A'),
                'description' => $process->process_description,
            ];
        });

        return view('erb.monitoring-process', compact('processes'));
    }

    public function erbReviewerIndex()
    {
       $reviewerId = Auth::user()->user_ID;

    // Get processes where reviewer is either the action taker OR the affected user
        $processes = ProcessMonitoring::with(['actionBy.researchInformation', 'affectedUser.researchInformation'])
            ->where(function($query) use ($reviewerId) {
                // Processes where reviewer performed the action
                $query->where('action_by_user_id', $reviewerId)
                    ->where('action_by_user_type', 'reviewer_erb');
            })
            ->orWhere(function($query) use ($reviewerId) {
                // Processes where reviewer is the affected user
                $query->where('affected_user_id', $reviewerId)
                    ->where('affected_user_type', 'reviewer_erb');
            })
            ->orderBy('timestamp', 'desc')
            ->get()
            ->map(function ($process) {
                return [
                    'description' => $process->process_description,
                    'date' => $process->timestamp->format('m/d/Y'),
                    'time' => $process->timestamp->format('h:i:s A'),
                ];
            });

        return view('erb-reviewer.monitoring-process', compact('processes'));
    }

    public function piIndex(){
        $studentId = Auth::user()->user_ID;

        // Get processes where student is either the action taker OR the affected user
        $processes = ProcessMonitoring::with(['actionBy.researchInformation', 'affectedUser.researchInformation'])
            ->where(function($query) use ($studentId) {
                // Processes where student performed the action
                $query->where('action_by_user_id', $studentId)
                      ->where('action_by_user_type', 'pi');
            })
            ->orWhere(function($query) use ($studentId) {
                // Processes where student is the affected user
                $query->where('affected_user_id', $studentId)
                      ->where('affected_user_type', 'pi');
            })
            ->orderBy('timestamp', 'desc')
            ->get()
            ->map(function ($process) {
                return [
                    'description' => $process->process_description,
                    'date' => $process->timestamp->format('m/d/Y'),
                    'time' => $process->timestamp->format('h:i:s A'),
                ];
            });

        return view('student.monitoring-process', compact('processes'));
    }

    public function iacucIndex()
    {
        $processes = ProcessMonitoring::with([
            'actionBy.researchInformation', 
            'affectedUser.researchInformation',
            'actionBy.classifications',
            'affectedUser.classifications'
        ])
        ->where(function($query) {
            $query->where('user_type', 'admin_iacuc')
                ->orWhere('user_type', 'reviewer_iacuc')
                ->orWhere(function($q) {
                    $q->where('user_type', 'pi')
                        ->where(function($subq) {
                            $subq->whereHas('actionBy', function($userQ) {
                                $userQ->whereHas('classifications', function($classQ) {
                                    $classQ->where('reviewClassification', 'IACUC');
                                });
                            })
                            ->orWhereHas('affectedUser', function($userQ) {
                                $userQ->whereHas('classifications', function($classQ) {
                                    $classQ->where('reviewClassification', 'IACUC');
                                });
                            });
                        });
                })
                ->orWhere('process_code', 'LIKE', 'IACUC%')
                ->orWhere('process_code', 'LIKE', 'REV_IACUC%');
        })
        ->orderBy('timestamp', 'desc')
        ->get()
        ->map(function ($process) {
            if ($process->direction === 'out') {
                $displayUser = $process->actionBy;
            } else {
                $displayUser = $process->affectedUser;
            }
            
            return [
                'pi_name' => $displayUser ? $displayUser->user_Fname . ' ' . $displayUser->user_Lname : 'System',
                'research_title' => $displayUser && $displayUser->researchInformation ? 
                    $displayUser->researchInformation->research_title : 'N/A',
                'account_type' => $displayUser ? $displayUser->user_Access : 'System',
                'date' => $process->timestamp->format('m/d/Y'),
                'time' => $process->timestamp->format('h:i:s A'),
                'description' => $process->process_description,
            ];
        });

        return view('iacuc.monitoring-process', compact('processes'));
    }

    public function iacucReviewerIndex()
    {
        $reviewerId = Auth::user()->user_ID;

        $processes = ProcessMonitoring::with(['actionBy.researchInformation', 'affectedUser.researchInformation'])
            ->where(function($query) use ($reviewerId) {
                // Processes where reviewer performed the action
                $query->where('action_by_user_id', $reviewerId)
                    ->where('action_by_user_type', 'reviewer_iacuc');
            })
            ->orWhere(function($query) use ($reviewerId) {
                // Processes where reviewer is the affected user
                $query->where('affected_user_id', $reviewerId)
                    ->where('affected_user_type', 'reviewer_iacuc');
            })
            ->orderBy('timestamp', 'desc')
            ->get()
            ->map(function ($process) {
                return [
                    'description' => $process->process_description,
                    'date' => $process->timestamp->format('m/d/Y'),
                    'time' => $process->timestamp->format('h:i:s A'),
                ];
            });

        return view('iacuc-reviewer.monitoring-process', compact('processes'));
    }
}
