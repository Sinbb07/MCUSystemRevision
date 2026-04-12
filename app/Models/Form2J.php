<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form2J extends Model
{
    use HasFactory;

    protected $table = 'tbl_form2j';
    protected $primaryKey = 'form2JID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'form2JID',
        'user_ID',
        // Radio button fields
        'potential_manner',
        'conditions_characteristics',
        'susceptible_risks',
        'special_vulnerability',
        'special_measures',
        'study_methods',
        'confidentiality',
        'confidential_procedures',
        'disposition_records',
        
        // Textarea fields
        'manner_described',
        'apply_characteristics',
        'exclusion_people',
        'relevant',
        'indicate_measures',
        'describe_study_methods',
        'anonymity',
        'discussed_confidentiality',
        'disposition_discuss',
        
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