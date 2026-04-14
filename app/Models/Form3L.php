<?php
// app/Models/Form3L.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form3L extends Model
{
    use HasFactory;

    protected $table = 'tbl_form3l';
    protected $primaryKey = 'form3LID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form3LID',
        'user_ID',
        'study_title',
        'study_site',
        'pi_name',
        'version_number_date',
        'tel_no',
        'contact_no',
        'pi_email',
        'co_investigators',
        'institution_researcher',
        'institution_address',
        'ethical_from_date',
        'ethical_to_date',
        'study_start',
        'study_end',
        'enrolled_participants',
        'required_participants',
        'participant_withdrew',
        'deviations',
        'issues_problems',
        'findings_summary',
        'conclusions',
        'action_dissemination',
    ];

    protected $casts = [
        'ethical_from_date' => 'date',
        'ethical_to_date' => 'date',
        'study_start' => 'date',
        'study_end' => 'date',
        'enrolled_participants' => 'integer',
        'required_participants' => 'integer',
        'participant_withdrew' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }
}