<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2D;
use Illuminate\Support\Facades\Auth;

class Form2DController extends Controller
{
    public function store(Request $request)
    {
        // Generate form2DID if new
        $lastId = Form2D::max('form2DID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form2DID = 'f2d' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form2DID = 'f2d000001';
        }

        // Prepare form data - ONLY textarea fields
        $formData = [
            'form2DID' => $form2DID,
            
            // Textarea fields from the form
            'statement_study_involve' => $request->statement_study_involve,
            'statement_study_purpose' => $request->statement_study_purpose,
            'explanation_inclusion' => $request->explanation_inclusion,
            'provisions' => $request->provisions,
            'withdrawal_statement' => $request->withdrawal_statement,
            'statement_study_nature' => $request->statement_study_nature,
            'disclose_risks_benefits' => $request->disclose_risks_benefits,
            'potential_benefits_statement' => $request->potential_benefits_statement,
            'provision_mitigations' => $request->provision_mitigations,
            'alternate_procedure_lists' => $request->alternate_procedure_lists,
            'statement_responsibilities' => $request->statement_responsibilities,
            'expenses_statement' => $request->expenses_statement,
            'compensation_statement' => $request->compensation_statement,
            'statement_participant_records' => $request->statement_participant_records,
            'data_protection_description' => $request->data_protection_description,
            'expected_study_duration' => $request->expected_study_duration,
            'approximate_number_subject' => $request->approximate_number_subject,
            'explanation_findings_results' => $request->explanation_findings_results,
            'person_contact' => $request->person_contact,
            'statement_approval' => $request->statement_approval,
            'manifestation_presentation' => $request->manifestation_presentation,
        ];

        // Save or update form data
        Form2D::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            $formData
        );

        return redirect()->back()->with('success', 'Form 2(D) has been saved successfully!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userId = $user->user_ID;

        // fetch draft if exists
        $form2d = Form2D::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form2D', compact('form2d', 'researchInfo', 'principalInvestigator'));
    }
}