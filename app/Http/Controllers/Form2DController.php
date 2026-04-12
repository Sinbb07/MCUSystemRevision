<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2D;
use Illuminate\Support\Facades\Auth;

class Form2DController extends Controller
{
    public function store(Request $request)
    {
        // Validate required fields
        $request->validate([
            'study_involvement' => 'required|in:Yes,No,NA',
            'study_purpose' => 'required|in:Yes,No,NA',
            'participant_inclusion' => 'required|in:Yes,No,NA',
            'voluntary' => 'required|in:Yes,No,NA',
            'withdraw' => 'required|in:Yes,No,NA',
            'study_nature' => 'required|in:Yes,No,NA',
            'risks_benefits' => 'required|in:Yes,No,NA',
            'potential_benefits' => 'required|in:Yes,No,NA',
            'mitigation' => 'required|in:Yes,No,NA',
            'alternate_procedure' => 'required|in:Yes,No,NA',
            'participant_responsibilities' => 'required|in:Yes,No,NA',
            'study_expenses' => 'required|in:Yes,No,NA',
            'compensation' => 'required|in:Yes,No,NA',
            'participant_records' => 'required|in:Yes,No,NA',
            'data_protection' => 'required|in:Yes,No,NA',
            'study_duration' => 'required|in:Yes,No,NA',
            'number_subject' => 'required|in:Yes,No,NA',
            'findings_results' => 'required|in:Yes,No,NA',
            'contact' => 'required|in:Yes,No,NA',
            'approval' => 'required|in:Yes,No,NA',
            'presentation_language' => 'required|in:Yes,No,NA',
        ]);

        // Generate form2DID if new
        $lastId = Form2D::max('form2DID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form2DID = 'f2d' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form2DID = 'f2d000001';
        }

        // Prepare all form data
        $formData = [
            'form2DID' => $form2DID,
            'study_involvement' => $request->study_involvement,
            'study_purpose' => $request->study_purpose,
            'participant_inclusion' => $request->participant_inclusion,
            'voluntary' => $request->voluntary,
            'withdraw' => $request->withdraw,
            'study_nature' => $request->study_nature,
            'risks_benefits' => $request->risks_benefits,
            'potential_benefits' => $request->potential_benefits,
            'mitigation' => $request->mitigation,
            'alternate_procedure' => $request->alternate_procedure,
            'participant_responsibilities' => $request->participant_responsibilities,
            'study_expenses' => $request->study_expenses,
            'compensation' => $request->compensation,
            'participant_records' => $request->participant_records,
            'data_protection' => $request->data_protection,
            'study_duration' => $request->study_duration,
            'number_subject' => $request->number_subject,
            'findings_results' => $request->findings_results,
            'contact' => $request->contact,
            'approval' => $request->approval,
            'presentation_language' => $request->presentation_language,
        ];

        // Only include textarea data if the corresponding radio is "Yes"
        if ($request->study_involvement === 'Yes') {
            $formData['statement_study_involve'] = $request->statement_study_involve;
        } else {
            $formData['statement_study_involve'] = null;
        }

        if ($request->study_purpose === 'Yes') {
            $formData['statement_study_purpose'] = $request->statement_study_purpose;
        } else {
            $formData['statement_study_purpose'] = null;
        }

        if ($request->participant_inclusion === 'Yes') {
            $formData['explanation_inclusion'] = $request->explanation_inclusion;
        } else {
            $formData['explanation_inclusion'] = null;
        }

        if ($request->voluntary === 'Yes') {
            $formData['provisions'] = $request->provisions;
        } else {
            $formData['provisions'] = null;
        }

        if ($request->withdraw === 'Yes') {
            $formData['withdrawal_statement'] = $request->withdrawal_statement;
        } else {
            $formData['withdrawal_statement'] = null;
        }

        // Continue this pattern for all textarea fields...
        if ($request->study_nature === 'Yes') {
            $formData['statement_study_nature'] = $request->statement_study_nature;
        } else {
            $formData['statement_study_nature'] = null;
        }

        if ($request->risks_benefits === 'Yes') {
            $formData['disclose_risks_benefits'] = $request->disclose_risks_benefits;
        } else {
            $formData['disclose_risks_benefits'] = null;
        }

        if ($request->potential_benefits === 'Yes') {
            $formData['potential_benefits_statement'] = $request->potential_benefits_statement;
        } else {
            $formData['potential_benefits_statement'] = null;
        }

        if ($request->mitigation === 'Yes') {
            $formData['provision_mitigations'] = $request->provision_mitigations;
        } else {
            $formData['provision_mitigations'] = null;
        }

        if ($request->alternate_procedure === 'Yes') {
            $formData['alternate_procedure_lists'] = $request->alternate_procedure_lists;
        } else {
            $formData['alternate_procedure_lists'] = null;
        }

        if ($request->participant_responsibilities === 'Yes') {
            $formData['statement_responsibilities'] = $request->statement_responsibilities;
        } else {
            $formData['statement_responsibilities'] = null;
        }

        if ($request->study_expenses === 'Yes') {
            $formData['expenses_statement'] = $request->expenses_statement;
        } else {
            $formData['expenses_statement'] = null;
        }

        if ($request->compensation === 'Yes') {
            $formData['compensation_statement'] = $request->compensation_statement;
        } else {
            $formData['compensation_statement'] = null;
        }

        if ($request->participant_records === 'Yes') {
            $formData['statement_participant_records'] = $request->statement_participant_records;
        } else {
            $formData['statement_participant_records'] = null;
        }

        if ($request->data_protection === 'Yes') {
            $formData['data_protection_description'] = $request->data_protection_description;
        } else {
            $formData['data_protection_description'] = null;
        }

        if ($request->study_duration === 'Yes') {
            $formData['expected_study_duration'] = $request->expected_study_duration;
        } else {
            $formData['expected_study_duration'] = null;
        }

        if ($request->number_subject === 'Yes') {
            $formData['approximate_number_subject'] = $request->approximate_number_subject;
        } else {
            $formData['approximate_number_subject'] = null;
        }

        if ($request->findings_results === 'Yes') {
            $formData['explanation_findings_results'] = $request->explanation_findings_results;
        } else {
            $formData['explanation_findings_results'] = null;
        }

        if ($request->contact === 'Yes') {
            $formData['person_contact'] = $request->person_contact;
        } else {
            $formData['person_contact'] = null;
        }

        if ($request->approval === 'Yes') {
            $formData['statement_approval'] = $request->statement_approval;
        } else {
            $formData['statement_approval'] = null;
        }

        if ($request->presentation_language === 'Yes') {
            $formData['manifestation_presentation'] = $request->manifestation_presentation;
        } else {
            $formData['manifestation_presentation'] = null;
        }

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