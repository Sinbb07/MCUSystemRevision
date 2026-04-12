<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form5E extends Model
{
    protected $table = 'tbl_form5e';
    protected $primaryKey = 'form5EID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'form5EID',
        'user_ID',
        'protocol',
        'pi_name',
        'coiname',
        'pi_contact',
        'pi_email',
        'institution',
        'institute_address',
        'erb_contact',

        // Basic Documents
        'cover_letter',
        'enrollment_proof',
        'letter',
        'complete_form2b',
        'complete_form2a',
        'complete_form2d',
        
        // Protocol Package
        'study_protocol',
        'form2c_eng',
        'form2c_fil',
        'data_collection',
        'cert_validator',
        'eng_7_12_yrs',
        'fil_7_12_yrs',
        'eng_13_17_yrs',
        'fil_13_17_yrs',
        'advertisement',
        'vitae',
        'gcp',
    ];

    protected $casts = [
        // Basic Documents
        'cover_letter' => 'boolean',
        'enrollment_proof' => 'boolean',
        'letter' => 'boolean',
        'complete_form2b' => 'boolean',
        'complete_form2a' => 'boolean',
        'complete_form2d' => 'boolean',
        
        // Protocol Package
        'study_protocol' => 'boolean',
        'form2c_eng' => 'boolean',
        'form2c_fil' => 'boolean',
        'data_collection' => 'boolean',
        'cert_validator' => 'boolean',
        'eng_7_12_yrs' => 'boolean',
        'fil_7_12_yrs' => 'boolean',
        'eng_13_17_yrs' => 'boolean',
        'fil_13_17_yrs' => 'boolean',
        'advertisement' => 'boolean',
        'vitae' => 'boolean',
        'gcp' => 'boolean',
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
