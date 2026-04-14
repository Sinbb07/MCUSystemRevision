<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form2D extends Model
{
    use HasFactory;
    protected $table = 'tbl_form2d';
    protected $primaryKey = 'form2DID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form2DID',
        'user_ID',

        'study_involvement',
        'statement_study_involve',

        'study_purpose',
        'statement_study_purpose',

        'participant_inclusion',
        'explanation_inclusion',

        'voluntary',
        'provisions',

        'withdraw',
        'withdrawal_statement',

        'study_nature',
        'statement_study_nature',

        'risks_benefits',
        'disclose_risks_benefits',

        'potential_benefits',
        'potential_benefits_statement',

        'mitigation',
        'provision_mitigations',

        'alternate_procedure',
        'alternate_procedure_lists',

        'participant_responsibilities',
        'statement_responsibilities',

        'study_expenses',
        'expenses_statement',

        'compensation',
        'compensation_statement',

        'participant_records',
        'statement_participant_records',

        'data_protection',
        'data_protection_description',

        'study_duration',
        'expected_study_duration',

        'number_subject',
        'approximate_number_subject',

        'findings_results',
        'explanation_findings_results',

        'contact',
        'person_contact',

        'approval',
        'statement_approval',
        
        'presentation_language',
        'manifestation_presentation'
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
