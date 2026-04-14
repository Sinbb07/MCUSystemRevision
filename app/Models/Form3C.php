<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form3C extends Model
{
     use HasFactory;

    protected $table = 'tbl_form3c';
    protected $primaryKey = 'form3CID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form3CID',
        'user_ID',
        'study_title',
        'study_site',
        'pi_name',
        'tel_no',
        'contact_no',
        'pi_email',
        'investigator_institution',
        'institution_address',
        'college_dept',
        'ethical_clearance',
        'study_start',
        'study_end',
        'enrolled_participants',
        'required_participants',
        'participant_withdrew',
        'deviations',
        'new_information',
        'issues_problems',
    ];

    protected $casts = [
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
