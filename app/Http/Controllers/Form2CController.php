<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2C;
use Illuminate\Support\Facades\Auth;

class Form2CController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'protocol' => 'nullable|string|max:255',
            'pi_name' => 'required|string|max:255',
            'coiname' => 'required|string|max:255',
            'pi_contact' => 'required|string|max:20',
            'pi_email' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'institute_address' => 'required|string|max:255',
            'erb_contact' => 'required|string|max:255',

            // Part III
            'description_purpose' => 'nullable|string',
            'procedures' => 'nullable|string',
            'participant_selection' => 'nullable|string',
            'participation' => 'nullable|string',
            'duration' => 'nullable|string',
            'risks_hazards' => 'nullable|string',
            'benefits' => 'nullable|string',
            'injury_management' => 'nullable|string',
            'compensation' => 'nullable|string',
            'confidentiality' => 'nullable|string',
            'right_to_refuse' => 'nullable|string',
            'title_name' => 'nullable|string|max:255',
            'approval_mcueerb' => 'nullable|string',
            'contact_mcueerb' => 'nullable|string',

            // Part IV
            'consent_q1' => 'nullable|string|in:Yes,No',
            'consent_q2' => 'nullable|string|in:Yes,No',
            'consent_q3' => 'nullable|string|in:Yes,No',
            'consent_q4' => 'nullable|string|in:Yes,No',
            'consent_q5' => 'nullable|string|in:Yes,No',
            'consent_q6' => 'nullable|string|in:Yes,No',
            'consent_q7' => 'nullable|string|in:Yes,No',
            'consent_q8' => 'nullable|string|in:Yes,No',
            'consent_q9' => 'nullable|string|in:Yes,No',
            'consent_q10' => 'nullable|string|in:Yes,No',
        ]);

        // Generate form2CID if new
        $lastId = Form2C::max('form2CID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form2CID = 'f2c' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form2CID = 'f2c000001';
        }

        // Save or update draft
        Form2C::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form2CID'  => $form2CID,
                'protocol'  => $request->protocol,
                'pi_name'    => auth()->user()->full_name,
                'coiname' => $request->coiname,
                'pi_contact' => $request->pi_contact,
                'pi_email' => $request->pi_email,
                'institution' => $request->institution,
                'institute_address' => $request->institute_address,
                'erb_contact' => $request->erb_contact,

                // Part III fields
                'description_purpose' => $request->description_purpose,
                'procedures' => $request->procedures,
                'participant_selection' => $request->participant_selection,
                'participation' => $request->participation,
                'duration' => $request->duration,
                'risks_hazards' => $request->risks_hazards,
                'benefits' => $request->benefits,
                'injury_management' => $request->injury_management,
                'compensation' => $request->compensation,
                'confidentiality' => $request->confidentiality,
                'right_to_refuse' => $request->right_to_refuse,
                'title_name' => $request->title_name,
                'approval_mcueerb' => $request->approval_mcueerb,
                'contact_mcueerb' => $request->contact_mcueerb,

                // Part IV: Certificate of Consent
                'consent_q1' => $request->consent_q1,
                'consent_q2' => $request->consent_q2,
                'consent_q3' => $request->consent_q3,
                'consent_q4' => $request->consent_q4,
                'consent_q5' => $request->consent_q5,
                'consent_q6' => $request->consent_q6,
                'consent_q7' => $request->consent_q7,
                'consent_q8' => $request->consent_q8,
                'consent_q9' => $request->consent_q9,
                'consent_q10' => $request->consent_q10,
            ]
        );

        return redirect()->back()->with('success', 'Your draft has been saved!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userEmail = $user->user_Email;
        $userId = $user->user_ID;

        // fetch draft if exists (safe null-checks to avoid errors)
        $form2c = Form2C::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form2c', compact('form2c', 'researchInfo','principalInvestigator'));
    }
}
