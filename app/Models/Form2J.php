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
        'protocol_ID',
        
        // Textarea fields (all comment fields from your blade)
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
    
    // Scope for approved forms
    public function scopeApproved($query)
    {
        return $query->where('action', 'Approve');
    }
    
    // Scope for disapproved forms
    public function scopeDisapproved($query)
    {
        return $query->where('action', 'Disapprove');
    }
}