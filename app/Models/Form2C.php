<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form2C extends Model
{
    protected $table = 'tbl_form2c';
    protected $primaryKey = 'form2CID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form2CID',
        'user_ID',
        'protocol',
        'pi_name',
        'coiname',
        'pi_contact',
        'pi_email',
        'institution',
        'institute_address',
        'erb_contact',
        'description_purpose',
        'procedures',
        'participant_selection',
        'participation',
        'duration',
        'risks_hazards',
        'benefits',
        'injury_management',
        'compensation',
        'confidentiality',
        'right_to_refuse',
        'title_name',
        'approval_mcueerb',
        'contact_mcueerb',
        'consent_q1',
        'consent_q2',
        'consent_q3',
        'consent_q4',
        'consent_q5',
        'consent_q6',
        'consent_q7',
        'consent_q8',
        'consent_q9',
        'consent_q10',
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
