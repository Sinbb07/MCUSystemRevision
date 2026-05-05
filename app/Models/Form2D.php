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
        
        // Only textarea fields
        'statement_study_involve',
        'statement_study_purpose',
        'explanation_inclusion',
        'provisions',
        'withdrawal_statement',
        'statement_study_nature',
        'disclose_risks_benefits',
        'potential_benefits_statement',
        'provision_mitigations',
        'alternate_procedure_lists',
        'statement_responsibilities',
        'expenses_statement',
        'compensation_statement',
        'statement_participant_records',
        'data_protection_description',
        'expected_study_duration',
        'approximate_number_subject',
        'explanation_findings_results',
        'person_contact',
        'statement_approval',
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