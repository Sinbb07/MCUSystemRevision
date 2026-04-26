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
        'protocol_ID',
        
        // Textarea comment fields
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
    
    // Cast action enum to keep it consistent
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'protocol_ID', 'protocol_ID');
    }
    
    // Helper method to check if form is complete
    public function isComplete()
    {
        return !is_null($this->action);
    }
    
    // Scope for filtering by action
    public function scopeWithAction($query, $action)
    {
        return $query->where('action', $action);
    }
}