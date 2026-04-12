<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form2E extends Model
{
    use HasFactory;

    protected $table = 'tbl_form2e';
    protected $primaryKey = 'form2EID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'form2EID',
        'user_ID',
        // Radio button fields
        'main_idea_study',
        'scientific_significance',
        'human_participants',
        'problem_statement',
        'background_study',
        'relevant_information',
        'population',
        'sample_size',
        'manner',
        'study_site',
        'research_questions',
        'conditions_characteristics',
        'characteristics',
        'participant_vulnerability',
        'special_vulnerability',
        'special_measures',
        'study_procedure',
        'overall_procedures',
        'anonymity_confidentiality',
        'maintained',
        'data_confidentiality',
        'records_data',
        'risks_likelihood',
        'duration',
        'techniques',
        
        // Textarea fields
        'main_idea_summarize',
        'significance_discuss',
        'require_human_participants',
        'problem_statement_address',
        'adequate',
        'information_discuss',
        'population_define',
        'approx_size',
        'participants_manner',
        'site_identify',
        'appropriate_questions',
        'apply_characteristics',
        'characteristics_disqualify',
        'involvement',
        'vulnerability_evaluation',
        'indicate_measures',
        'describe_procedure',
        'overall_procedure_describe',
        'confidentiality_measures',
        'describe_maintain',
        'preserve_data',
        'disposition_records',
        'minimize_maximize',
        'estimated_date',
        'techniques_described',
        
        // Summary of Recommendations
        'summary_recommendation_1',
        'summary_recommendation_2',
        'summary_recommendation_3',
        'summary_recommendation_4',
        
        // Recommended Action
        'action',
        
        // Justification
        'justification',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID');
    }
}