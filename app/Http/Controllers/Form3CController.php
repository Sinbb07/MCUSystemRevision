<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3C;
use Illuminate\Support\Facades\Auth;

class Form3CController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'study_title' => 'required|string|max:255',
            'study_site' => 'required|string|max:255',
            'pi_name' => 'required|string|max:255',
            'tel_no' => 'nullable|string|max:20',
            'contact_no' => 'required|string|max:20',
            'pi_email' => 'required|email|max:255',
            'investigator_institution' => 'required|string|max:255',
            'institution_address' => 'required|string|max:255',
            'college_dept' => 'required|string|max:255',
            'ethical_clearance' => 'required|string|max:255',
            'study_start' => 'required|date',
            'study_end' => 'required|date|after_or_equal:study_start',
            'enrolled_participants' => 'required|integer|min:0',
            'required_participants' => 'required|integer|min:1',
            'participant_withdrew' => 'required|integer|min:0',
            'deviations' => 'required|string|max:255',
            'new_information' => 'nullable|string',
            'issues_problems' => 'nullable|string',
        ]);

        // Generate form3CID if new
        $lastId = Form3C::max('form3CID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form3CID = 'f3c' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form3CID = 'f3c000001';
        }

        // Save or update draft
        Form3C::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form3CID' => $form3CID,
                'study_title' => $request->study_title,
                'study_site' => $request->study_site,
                'pi_name' => $request->pi_name,
                'tel_no' => $request->tel_no,
                'contact_no' => $request->contact_no,
                'pi_email' => $request->pi_email,
                'investigator_institution' => $request->investigator_institution,
                'institution_address' => $request->institution_address,
                'college_dept' => $request->college_dept,
                'ethical_clearance' => $request->ethical_clearance,
                'study_start' => $request->study_start,
                'study_end' => $request->study_end,
                'enrolled_participants' => $request->enrolled_participants,
                'required_participants' => $request->required_participants,
                'participant_withdrew' => $request->participant_withdrew,
                'deviations' => $request->deviations,
                'new_information' => $request->new_information,
                'issues_problems' => $request->issues_problems,
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
        $form3c = Form3C::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3c', compact('form3c', 'researchInfo', 'principalInvestigator'));
    }
}