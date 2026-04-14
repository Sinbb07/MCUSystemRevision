<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3L;
use Illuminate\Support\Facades\Auth;

class Form3LController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'study_title' => 'required|string|max:255',
            'study_site' => 'required|string|max:255',
            'pi_name' => 'required|string|max:255',
            'version_number_date' => 'required|string|max:255',
            'tel_no' => 'nullable|string|max:20',
            'contact_no' => 'required|string|max:20',
            'pi_email' => 'required|email|max:255',
            'co_investigators' => 'nullable|string|max:255',
            'institution_researcher' => 'required|string|max:255',
            'institution_address' => 'required|string|max:255',
            'ethical_from_date' => 'required|date',
            'ethical_to_date' => 'required|date|after_or_equal:ethical_from_date',
            'study_start' => 'required|date',
            'study_end' => 'required|date|after_or_equal:study_start',
            'enrolled_participants' => 'required|integer|min:0',
            'required_participants' => 'required|integer|min:1',
            'participant_withdrew' => 'required|integer|min:0',
            'deviations' => 'required|string|max:255',
            'issues_problems' => 'nullable|string',
            'findings_summary' => 'nullable|string',
            'conclusions' => 'nullable|string',
            'action_dissemination' => 'nullable|string',
        ]);

        // Generate form3LID if new
        $lastId = Form3L::max('form3LID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form3LID = 'f3l' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form3LID = 'f3l000001';
        }

        // Save or update draft
        Form3L::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form3LID' => $form3LID,
                'study_title' => $request->study_title,
                'study_site' => $request->study_site,
                'pi_name' => $request->pi_name,
                'version_number_date' => $request->version_number_date,
                'tel_no' => $request->tel_no,
                'contact_no' => $request->contact_no,
                'pi_email' => $request->pi_email,
                'co_investigators' => $request->co_investigators,
                'institution_researcher' => $request->institution_researcher,
                'institution_address' => $request->institution_address,
                'ethical_from_date' => $request->ethical_from_date,
                'ethical_to_date' => $request->ethical_to_date,
                'study_start' => $request->study_start,
                'study_end' => $request->study_end,
                'enrolled_participants' => $request->enrolled_participants,
                'required_participants' => $request->required_participants,
                'participant_withdrew' => $request->participant_withdrew,
                'deviations' => $request->deviations,
                'issues_problems' => $request->issues_problems,
                'findings_summary' => $request->findings_summary,
                'conclusions' => $request->conclusions,
                'action_dissemination' => $request->action_dissemination,
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
        $form3l = Form3L::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3l', compact('form3l', 'researchInfo', 'principalInvestigator'));
    }

}