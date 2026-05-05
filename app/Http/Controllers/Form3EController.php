<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3E;
use Illuminate\Support\Facades\Auth;

class Form3EController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'amend_provisions' => 'nullable|string',
            'orig_procedure' => 'nullable|string',
            'proposed_amendments' => 'nullable|string',
            'justification' => 'nullable|string',
        ]);

        // Get existing form to check if we need to generate new ID
        $existingForm = Form3E::where('user_ID', Auth::user()->user_ID)->first();
        
        if ($existingForm) {
            $form3EID = $existingForm->form3EID;
        } else {
            // Generate form3EID if new
            $lastId = Form3E::max('form3EID');
            if ($lastId) {
                $num = intval(substr($lastId, 3)) + 1;
                $form3EID = 'f3e' . str_pad($num, 6, '0', STR_PAD_LEFT);
            } else {
                $form3EID = 'f3e000001';
            }
        }

        // Save or update draft
        Form3E::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form3EID' => $form3EID,
                'amend_provisions' => $request->amend_provisions,
                'orig_procedure' => $request->orig_procedure,
                'proposed_amendments' => $request->proposed_amendments,
                'justification' => $request->justification,
            ]
        );

        return redirect()->back()->with('success', 'Form 3(E) has been saved successfully!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userId = $user->user_ID;

        // fetch draft if exists
        $form3e = Form3E::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3e', compact('form3e', 'researchInfo', 'principalInvestigator'));
    }
}