<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2B;
use Illuminate\Support\Facades\Auth;

class Form2BController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'protocol_title' => 'required|string|max:255',
            'pi_name' => 'required|string|max:255',
            'pi_contact' => 'required|string|max:20',
            'pi_email' => 'required|string|max:255',
            'coiname' => 'required|string|max:255',
            'investigator_type' => 'required|string',
            'protocol' => 'required|string|max:255',
            'college_institution' => 'required|string|max:255',
            'submitted_by' => 'required|string|max:255',
            'study_type' => 'required|string',
            'study_type_text' => 'nullable|string|max:255',
            'protocol_description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings_site' => 'required|string|max:255',
            'study_participants' => 'required|string|max:255',
            'funds' => 'required|string',
            'funds_pharma_details' => 'required_if:funds,Pharmaceutical|string|max:255',
            'funds_others_details' => 'required_if:funds,Others|string|max:255',
            'tech_review'   => 'required|boolean',
            'erb_submit'   => 'required|boolean',
            'information_confidentiality' => 'required|string',
            'participants_vulnerability' => 'required|string',
            'study_risks' => 'required|string',
            'study_benefits' => 'required|string',
            'patient_related' => 'required|string',
            'informed_consent_process' => 'required|string',
            'community_considerations' => 'required|string',
            'dissemination' => 'required|string',
            'collaborative_terms' => 'required|string',

            // Special Population
            'special_population' => 'required|string',
            'special_population_others' => 'required_if:special_population,Others|string|max:255',
        ]);

        // Generate form2BID if new
        $lastId = Form2B::max('form2BID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form2BID = 'f2b' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form2BID = 'f2b000001';
        }

        // ✅ unify funds details
        $fundsDetails = null;
        if ($request->funds === 'Pharmaceutical') {
            $fundsDetails = $request->funds_pharma_details;
        } elseif ($request->funds === 'Others') {
            $fundsDetails = $request->funds_others_details;
        }

        // ✅ unify special population
        $specialPopulation = $request->special_population;
        $specialPopulationOthers = null;
        if ($specialPopulation === 'Others') {
            $specialPopulationOthers = $request->special_population_others;
        }

        // Save or update draft
        Form2B::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form2BID'  => $form2BID,
                'protocol'  => $request->protocol,
                'pi_name'    => auth()->user()->full_name,
                'pi_contact' => $request->pi_contact,
                'pi_email' => $request->pi_email,
                'coiname' => $request->coiname,
                'investigator_type' => $request->investigator_type,
                'college_institution' => $request->college_institution,
                'submitted_by' => $request->submitted_by,
                'study_type' => $request->study_type,
                'study_type_text' => $request->study_type_text,
                'protocol_description' => $request->protocol_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'settings_site' => $request->settings_site,
                'study_participants' => $request->study_participants,

                // funds
                'funds' => $request->funds,
                'funds_details' => $fundsDetails,

                'tech_review'  => $request->tech_review,
                'erb_submit'  => $request->erb_submit,

                // consent & ethics
                'information_confidentiality' => $request->information_confidentiality,
                'participants_vulnerability' => $request->participants_vulnerability,
                'study_risks' => $request->study_risks,
                'study_benefits' => $request->study_benefits,
                'patient_related' => $request->patient_related,
                'informed_consent_process' => $request->informed_consent_process,
                'community_considerations' => $request->community_considerations,
                'dissemination' => $request->dissemination,
                'collaborative_terms' => $request->collaborative_terms,

                // ✅ special population
                'special_population' => $specialPopulation,
                'special_population_others' => $specialPopulationOthers,
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
        $form2b = Form2B::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form2b', compact('form2b', 'researchInfo', 'principalInvestigator'));
    }
}
