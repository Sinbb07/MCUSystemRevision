<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form2A extends Model
{
    protected $table = 'tbl_form2a';
    protected $primaryKey = 'form2AID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'form2AID',
        'user_ID',
        'protocol',
        'pi_name',
        'coiname',

        // Basic Documents
        'cover_letter',
        'enrollment_proof',
        'employment_proof',
        'letter',
        'complete_form2b',
        'complete_form2a',
        'complete_form2d',

        // Protocol Package
        'study_protocol',
        'form2c_eng',
        'form2c_fil',
        'data_collection',
        'cert_validator',
        'eng_7_12_yrs',
        'fil_7_12_yrs',
        'eng_13_17_yrs',
        'fil_13_17_yrs',
        'advertisement',
        'vitae',
        'gcp',
        'gantt_chart',

        // Seniors
        'sen_ic', 'informed_consent',
        'sen_ca', 'cognitive_assessment',
        'sen_phr', 'physical_risks',
        'sen_raa', 'respect_autonomy',
        'sen_pac', 'privacy_confidentiality',
        'sen_is', 'intervention_suitability',

        // Minors
        'min_pgc', 'parent_consent',
        'min_ap', 'assent_process',
        'min_pfh', 'harm_protection',
        'min_eb', 'educational_balance',
        'min_mr', 'mandatory_reporting',
        'min_ei', 'equitable_inclusion',

        // PWD
        'pwd_ac', 'accessible_comm',
        'pwd_cc', 'consent_capacity',
        'pwd_rm', 'risk_mitigation',
        'pwd_nd', 'non_discrimination',
        'pwd_ra', 'reasonable_accommodations',
        'pwd_m', 'monitoring',

        // PDOL
        'pdol_vp', 'voluntary_participation',
        'pdol_es', 'equitable_selection',
        'pdol_pac2', 'privacy_confidentiality_2',
        'pdol_bara', 'benefit_risk_analysis',
        'pdol_io', 'independent_oversight',
        'pdol_pss', 'post_study_support',

        // General Principles
        'gpfag_ej', 'ethical_justification',
        'gpfag_sv', 'scientific_validity',
        'gpfag_rba', 'risk_benefit_assessment',
        'gpfag_cs', 'cultural_sensitivity',
        'gpfag_c', 'compensation',

        // Recruitment
        'popr_pp', 'potential_participants',
        'popr_cc', 'conditions_characteristics',
        'popr_str', 'susceptible_to_risks',
        'popr_sv', 'special_vulnerability',
        'popr_pi', 'possible_indication',
        'popr_p', 'procedure',

        // Sample size
        'sample_size_1', 'sample_size_2',

        // Site of data collection
        'sodc_ac', 'anonymity_confidentiality',
        'sodc_pc', 'procedures_confidentiality',
        'sodc_fd', 'final_disposition',

        // Last part
        'thesisadviser', 'notedby', 'coordinator',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function researchInfo()
    {
    return $this->hasOne(ResearchInformation::class, 'user_ID', 'user_ID');
    }

}
