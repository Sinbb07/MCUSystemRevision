<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form3A extends Model
{
    protected $table = 'tbl_form3a';
    protected $primaryKey = 'form3AID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'form3AID',
        'user_ID',
        'protocol',
        'version_no',
        'study_site',
        'pi_name',
        'coi_name',
        'tel_no',
        'contact_no',
        'pi_email',
        'investigator_institution',
        'institution_address',
        'recommendations',
        'research_response',
        'section_page_number',
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
