<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IacucProtocolReview extends Model
{
    protected $table = 'tbl_iacuc_protocol_review';
    protected $primaryKey = 'review_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'review_id',
        'user_ID',
        'protocol_ID',
        'study_title',
        'pi_person',
        'adviser',
        'scientific_merit_comment',
        'training_experience_comment',
        'overview_section_comment',
        'rational_justification_comment',
        'adequate_justification_comment',
        'unnecessary_duplication_comment',
        'experimental_procedures_comment',
        'endpoint_duration_comment',
        'euthanasia_method_comment',
        'pain_category_comment',
        'alternative_housing_comment',
        'hazardous_material_comment',
        'multiple_survival_comment',
        'pain_relief_comment',
        'ill_debilitated_comment',
        'complications_comment',
        'veterinary_complications_comment',
        'proposed_anesthesia_comment',
        'post_procedural_comment',
        'appropriate_method_comment',
        'summary_comments',
        'refinements_comment',
    ];
}
