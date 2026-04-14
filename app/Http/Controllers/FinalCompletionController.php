<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ResearchFiles;
use App\Models\Approved;

class FinalCompletionController extends Controller
{
    public function index()
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

        return view('erb.final-completion', compact('principalInvestigators'));
    }
}