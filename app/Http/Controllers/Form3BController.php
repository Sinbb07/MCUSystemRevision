<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3B;
use Illuminate\Support\Facades\Auth;

class Form3BController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'total_participants' => 'nullable|integer|min:0',
            'review_type' => 'nullable|in:2nd_review,3rd_review',
            'recommendation_from_last_review' => 'nullable|string',
            'recommendation_indication' => 'nullable|string',
            'protocol_issues_1' => 'nullable|string',
            'protocol_issues_2' => 'nullable|string',
            'indicate_protocol_related' => 'nullable|string',
            'protocol_related_page' => 'nullable|string',
            'ethical_issues_1' => 'nullable|string',
            'ethical_issues_2' => 'nullable|string',
            'indicate_ethical_issue' => 'nullable|string',
            'ethical_related_page' => 'nullable|string',
            'consent_issues_1' => 'nullable|string',
            'consent_issues_2' => 'nullable|string',
            'indicate_consent_related' => 'nullable|string',
            'consent_related_page' => 'nullable|string',
            'review_changes_1' => 'nullable|string',
            'review_changes_2' => 'nullable|string',
            'indicate_review_changes' => 'nullable|string',
            'review_changes_page' => 'nullable|string',
        ]);

        // Generate form3BID if new
        $existingForm = Form3B::where('user_ID', Auth::user()->user_ID)->first();
        
        if ($existingForm) {
            $form3BID = $existingForm->form3BID;
        } else {
            $lastId = Form3B::max('form3BID');
            if ($lastId) {
                $num = intval(substr($lastId, 3)) + 1;
                $form3BID = 'f3b' . str_pad($num, 6, '0', STR_PAD_LEFT);
            } else {
                $form3BID = 'f3b000001';
            }
        }

        // Save or update
        Form3B::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form3BID' => $form3BID,
                'total_participants' => $request->total_participants,
                'review_type' => $request->review_type,
                'recommendation_from_last_review' => $request->recommendation_from_last_review,
                'recommendation_indication' => $request->recommendation_indication,
                'protocol_issues_1' => $request->protocol_issues_1,
                'protocol_issues_2' => $request->protocol_issues_2,
                'indicate_protocol_related' => $request->indicate_protocol_related,
                'protocol_related_page' => $request->protocol_related_page,
                'ethical_issues_1' => $request->ethical_issues_1,
                'ethical_issues_2' => $request->ethical_issues_2,
                'indicate_ethical_issue' => $request->indicate_ethical_issue,
                'ethical_related_page' => $request->ethical_related_page,
                'consent_issues_1' => $request->consent_issues_1,
                'consent_issues_2' => $request->consent_issues_2,
                'indicate_consent_related' => $request->indicate_consent_related,
                'consent_related_page' => $request->consent_related_page,
                'review_changes_1' => $request->review_changes_1,
                'review_changes_2' => $request->review_changes_2,
                'indicate_review_changes' => $request->indicate_review_changes,
                'review_changes_page' => $request->review_changes_page,
            ]
        );

        return redirect()->back()->with('success', 'Form 3(B) has been saved successfully!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userId = $user->user_ID;

        $form3b = Form3B::where('user_ID', $userId)->first();
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3b', compact('form3b', 'researchInfo', 'principalInvestigator'));
    }
}