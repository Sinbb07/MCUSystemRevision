<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form3B extends Model
{
    use HasFactory;

    protected $table = 'tbl_form3b';
    protected $primaryKey = 'form3BID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form3BID',
        'user_ID',
        'mcu_erb_code',
        'initial_submission_date',
        'study_protocol_title',
        'resubmitted_submission_date',
        'principal_investigator',
        'telephone',
        'initial_review_date',
        'last_review_date',
        'total_participants',
        'review_type',
        'recommendation_from_last_review',
        'contains_specified_assessment',
        'assessment_indication',
        'protocol_issues_1',
        'protocol_issues_2',
        'protocol_contains_assessment',
        'protocol_assessment_indication',
        'protocol_related_page',
        'ethical_issues_1',
        'ethical_issues_2',
        'ethical_contains_assessment',
        'ethical_assessment_indication',
        'ethical_related_page',
        'consent_issues_1',
        'consent_issues_2',
        'consent_contains_assessment',
        'consent_assessment_indication',
        'consent_related_page',
        'review_changes_1',
        'review_changes_2',
        'changes_contains_assessment',
        'changes_assessment_indication',
        'review_changes_page',
    ];

    protected $casts = [
        'initial_submission_date' => 'date',
        'resubmitted_submission_date' => 'date',
        'initial_review_date' => 'date',
        'last_review_date' => 'date',
        'contains_specified_assessment' => 'boolean',
        'protocol_contains_assessment' => 'boolean',
        'ethical_contains_assessment' => 'boolean',
        'consent_contains_assessment' => 'boolean',
        'changes_contains_assessment' => 'boolean',
    ];

    /**
     * Get the user that owns the form.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    /**
     * Get the research information associated with the user.
     */
    public function researchInformation()
    {
        return $this->hasOne(ResearchInformation::class, 'user_ID', 'user_ID');
    }
}