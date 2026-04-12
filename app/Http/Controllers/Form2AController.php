<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2A;
use Illuminate\Support\Facades\Auth;

class Form2AController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'protocol' => 'nullable|string|max:255',
            'pi_name' => 'required|string|max:255',
            'coiname' => 'nullable|string|max:255',

            //Seniors
            'informed_consent' => 'nullable|string',
            'cognitive_assessment' => 'nullable|string',
            'physical_risks' => 'nullable|string',
            'respect_autonomy' => 'nullable|string',
            'privacy_confidentiality' => 'nullable|string',
            'intervention_suitability' => 'nullable|string', 

            //Minors
            'parent_consent' => 'nullable|string',
            'assent_process' => 'nullable|string',
            'harm_protection' => 'nullable|string',
            'educational_balance' => 'nullable|string',
            'mandatory_reporting' => 'nullable|string',
            'equitable_inclusion' => 'nullable|string', 

            //Persons with Disabilities
            'accessible_comm' => 'nullable|string',
            'consent_capacity' => 'nullable|string',
            'risk_mitigation' => 'nullable|string',
            'non_discrimination' => 'nullable|string',
            'reasonable_accommodations' => 'nullable|string',
            'monitoring' => 'nullable|string', 

            //Person Deprived of Liberty
            'voluntary_participation' => 'nullable|string',
            'equitable_selection' => 'nullable|string',
            'privacy_confidentiality_2' => 'nullable|string',
            'benefit_risk_analysis' => 'nullable|string',
            'independent_oversight' => 'nullable|string',
            'post_study_support' => 'nullable|string', 

            //General Principles for All Groups
            'ethical_justification' => 'nullable|string',
            'scientific_validity' => 'nullable|string',
            'risk_benefit_assessment' => 'nullable|string',
            'cultural_sensitivity' => 'nullable|string',
            'compensation' => 'nullable|string',
            
            //Process of Participant Recruitment
            'potential_participants' => 'nullable|string',
            'conditions_characteristics' => 'nullable|string',
            'susceptible_to_risks' => 'nullable|string',
            'special_vulnerability' => 'nullable|string',
            'possible_indication' => 'nullable|string',
            'procedure' => 'nullable|string', 

            //Sample size and suitable determination procedure
            'sample_size_1' => 'nullable|string',
            'sample_size_2' => 'nullable|string',
            
            //Site of data collection
            'anonymity_confidentiality' => 'nullable|string',
            'procedures_confidentiality' => 'nullable|string',
            'final_disposition' => 'nullable|string', 
            //Last Part
            'thesisadviser' => 'required|string|max:255',
            'notedby' => 'required|string|max:255',
            'coordinator' => 'required|string|max:255', 
        ]);

        // Generate form2BID if new
        $lastId = Form2A::max('form2AID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form2AID = 'f2a' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form2AID = 'f2a000001';
        }

        // Save or update draft
        Form2A::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form2AID'  => $form2AID,
                'protocol'  => $request->protocol,
                'pi_name'  => $request->pi_name,
                'coiname'  => $request->coiname,

                //Basic Documents
                'cover_letter' => $request->has('cover_letter'),
                'enrollment_proof' => $request->has('enrollment_proof'),
                'employment_proof' => $request->has('employment_proof'),
                'letter' => $request->has('letter'),
                'complete_form2b' => $request->has('complete_form2b'),
                'complete_form2a' => $request->has('complete_form2a'),
                'complete_form2d' => $request->has('complete_form2d'),

                //Protocol Package
                'study_protocol' => $request->has('study_protocol'),
                'form2c_eng' => $request->has('form2c_eng'),
                'form2c_fil' => $request->has('form2c_fil'),
                'data_collection' => $request->has('data_collection'),
                'cert_validator' => $request->has('cert_validator'),
                'eng_7_12_yrs' => $request->has('eng_7_12_yrs'),
                'fil_7_12_yrs' => $request->has('fil_7_12_yrs'),
                'eng_13_17_yrs' => $request->has('eng_13_17_yrs'),
                'fil_13_17_yrs' => $request->has('fil_13_17_yrs'),
                'advertisement' => $request->has('advertisement'),
                'vitae' => $request->has('vitae'),
                'gcp' => $request->has('gcp'),
                'gantt_chart' => $request->has('gantt_chart'),

                // Seniors
                'sen_ic' => $request->has('sen_ic'),
                'informed_consent'           => $request->informed_consent,
                'sen_ca' => $request->has('sen_ca'),
                'cognitive_assessment'       => $request->cognitive_assessment,
                'sen_phr' => $request->has('sen_phr'),
                'physical_risks'             => $request->physical_risks,
                'sen_raa' => $request->has('sen_raa'),
                'respect_autonomy'           => $request->respect_autonomy,
                'sen_pac' => $request->has('sen_pac'),
                'privacy_confidentiality'    => $request->privacy_confidentiality,
                'sen_is' => $request->has('sen_is'),
                'intervention_suitability'   => $request->intervention_suitability,

                // Minors
                'min_pgc' => $request->has('min_pgc'),
                'parent_consent'             => $request->parent_consent,
                'min_ap' => $request->has('min_ap'),
                'assent_process'             => $request->assent_process,
                'min_pfh' => $request->has('min_pfh'),
                'harm_protection'            => $request->harm_protection,
                'min_eb' => $request->has('min_eb'),
                'educational_balance'        => $request->educational_balance,
                'min_mr' => $request->has('min_mr'),
                'mandatory_reporting'        => $request->mandatory_reporting,
                'min_ei' => $request->has('min_ei'),
                'equitable_inclusion'        => $request->equitable_inclusion,

                // Persons with Disabilities
                'pwd_ac' => $request->has('pwd_ac'),
                'accessible_comm'            => $request->accessible_comm,
                'pwd_cc' => $request->has('pwd_cc'),
                'consent_capacity'           => $request->consent_capacity,
                'pwd_rm' => $request->has('pwd_rm'),
                'risk_mitigation'            => $request->risk_mitigation,
                'pwd_nd' => $request->has('pwd_nd'),
                'non_discrimination'         => $request->non_discrimination,
                'pwd_ra' => $request->has('pwd_ra'),
                'reasonable_accommodations'  => $request->reasonable_accommodations,
                'pwd_m' => $request->has('pwd_m'),
                'monitoring'                 => $request->monitoring,

                // Person Deprived of Liberty
                'pdol_vp' => $request->has('pdol_vp'),
                'voluntary_participation'    => $request->voluntary_participation,
                'pdol_es' => $request->has('pdol_es'),
                'equitable_selection'        => $request->equitable_selection,
                'pdol_pac2' => $request->has('pdol_pac2'),
                'privacy_confidentiality_2'  => $request->privacy_confidentiality_2,
                'pdol_bara' => $request->has('pdol_bara'),
                'benefit_risk_analysis'      => $request->benefit_risk_analysis,
                'pdol_io' => $request->has('pdol_io'),
                'independent_oversight'      => $request->independent_oversight,
                'pdol_pss' => $request->has('pdol_pss'),
                'post_study_support'         => $request->post_study_support,

                // General Principles for All Groups
                'gpfag_ej' => $request->has('gpfag_ej'),
                'ethical_justification'      => $request->ethical_justification,
                'gpfag_sv' => $request->has('gpfag_sv'),
                'scientific_validity'        => $request->scientific_validity,
                'gpfag_rba' => $request->has('gpfag_rba'),
                'risk_benefit_assessment'    => $request->risk_benefit_assessment,
                'gpfag_cs' => $request->has('gpfag_cs'),
                'cultural_sensitivity'       => $request->cultural_sensitivity,
                'gpfag_c' => $request->has('gpfag_c'),
                'compensation'               => $request->compensation,

                // Process of Participant Recruitment
                'popr_pp' => $request->has('popr_pp'),
                'potential_participants'     => $request->potential_participants,
                'popr_cc' => $request->has('popr_cc'),
                'conditions_characteristics' => $request->conditions_characteristics,
                'popr_str' => $request->has('popr_str'),
                'susceptible_to_risks'       => $request->susceptible_to_risks,
                'popr_sv' => $request->has('popr_sv'),
                'special_vulnerability'      => $request->special_vulnerability,
                'popr_pi' => $request->has('popr_pi'),
                'possible_indication'        => $request->possible_indication,
                'popr_p' => $request->has('popr_p'),
                'procedure'                  => $request->procedure,

                // Sample size and suitable determination procedure
                'sample_size_1'              => $request->sample_size_1,
                'sample_size_2'              => $request->sample_size_2,

                // Site of data collection
                'sodc_ac' => $request->has('sodc_ac'),
                'anonymity_confidentiality'  => $request->anonymity_confidentiality,
                'sodc_pc' => $request->has('sodc_pc'),
                'procedures_confidentiality' => $request->procedures_confidentiality,
                'sodc_fd' => $request->has('sodc_fd'),
                'final_disposition'          => $request->final_disposition,

                // Last Part
                'thesisadviser'              => $request->thesisadviser,
                'notedby'                    => $request->notedby,
                'coordinator'                => $request->coordinator,

            ]
        );

        return redirect()->back()->with('success', 'Your draft has been saved!');
    }
    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        $userId = $user->user_ID;

        // fetch draft if exists (safe null-checks to avoid errors)
        $form2a = Form2A::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form2a', compact('form2a', 'researchInfo', 'principalInvestigator'));
    }
}
