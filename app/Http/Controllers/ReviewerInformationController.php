<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewerInformation;

class ReviewerInformationController extends Controller
{
    // ==========================
    // IACUC Reviewer Methods
    // ==========================
    public function iacucCreate()
    {
        return view('iacuc-reviewer.college-dept');
    }

    public function iacucStore(Request $request)
    {
        $request->validate([
            'Reviewer_Dept' => 'required|string|max:255',
            'Reviewer_Prog' => 'required|string|max:255',
            'reviewer_type' => 'required|in:Medical,Non-medical'
        ]);

        // Check if user already has a record
        $existingReviewer = ReviewerInformation::where('user_ID', Auth::user()->user_ID)->first();
        
        if ($existingReviewer) {
            // Update existing record
            $existingReviewer->update([
                'Reviewer_Dept' => $request->Reviewer_Dept,
                'Reviewer_Prog' => $request->Reviewer_Prog,
                'reviewer_type' => $request->reviewer_type
            ]);
            
            $message = 'Information updated successfully.';
        } else {
            // Create new record
            ReviewerInformation::create([
                'Reviewer_ID' => $this->generateReviewerID(),
                'user_ID' => Auth::user()->user_ID,
                'Reviewer_Dept' => $request->Reviewer_Dept,
                'Reviewer_Prog' => $request->Reviewer_Prog,
                'reviewer_type' => $request->reviewer_type
            ]);
            
            $message = 'Information saved successfully.';
        }

        return redirect()->route('iacuc-reviewer.dashboard')
                         ->with('success', $message);
    }

    // ==========================
    // ERB Reviewer Methods
    // ==========================
    public function erbCreate()
    {
        return view('erb-reviewer.college-dept');
    }

    public function erbStore(Request $request)
    {
        $request->validate([
            'Reviewer_Dept' => 'required|string|max:255',
            'Reviewer_Prog' => 'required|string|max:255',
            'reviewer_type' => 'required|in:Medical,Non-medical'
        ]);

        $exists = ReviewerInformation::where('user_ID', auth()->user()->user_ID)->exists();

        if ($exists) {
            ReviewerInformation::where('user_ID', auth()->user()->user_ID)
                ->update([
                    'Reviewer_Dept' => $request->Reviewer_Dept,
                    'Reviewer_Prog' => $request->Reviewer_Prog,
                    'reviewer_type' => $request->reviewer_type,
                    'updated_at' => now()
                ]);
        } else {
            ReviewerInformation::create([
                'Reviewer_ID' => $this->generateReviewerID(),
                'user_ID' => auth()->user()->user_ID,
                'Reviewer_Dept' => $request->Reviewer_Dept,
                'Reviewer_Prog' => $request->Reviewer_Prog,
                'reviewer_type' => $request->reviewer_type
            ]);
        }

        return redirect()->route('erb-reviewer.dashboard')
                         ->with('success', 'Profile updated successfully!');
    }

    // ==========================
    // Shared method: generate REV-000XX ID
    // ==========================
    private function generateReviewerID()
    {
        $lastRecord = ReviewerInformation::orderBy('Reviewer_ID', 'desc')->first();

        if (!$lastRecord) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) str_replace('REV-', '', $lastRecord->Reviewer_ID);
            $nextNumber = $lastNumber + 1;
        }

        return 'REV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}