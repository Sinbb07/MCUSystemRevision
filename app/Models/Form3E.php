<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form3E extends Model
{
    protected $table = 'tbl_form3e';
    protected $primaryKey = 'form3EID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'form3EID',
        'user_ID',
        'amend_provisions',
        'orig_procedure',
        'proposed_amendments',
        'justification',    
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
