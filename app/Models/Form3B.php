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
        'total_participants',
        'review_type',
        'recommendation_from_last_review',
        'recommendation_indication',
        'protocol_issues_1',
        'protocol_issues_2',
        'indicate_protocol_related',
        'protocol_related_page',
        'ethical_issues_1',
        'ethical_issues_2',
        'indicate_ethical_issue',
        'ethical_related_page',
        'consent_issues_1',
        'consent_issues_2',
        'indicate_consent_related',
        'consent_related_page',
        'review_changes_1',
        'review_changes_2',
        'indicate_review_changes',
        'review_changes_page',
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