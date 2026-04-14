<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form3D extends Model
{
    use HasFactory;

    protected $table = 'tbl_form3d';
    protected $primaryKey = 'form3DID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'form3DID',
        'user_ID',
        'add_remove',
        'add_methods',
        'additional_data',
        'remove_participants',
        'minor_changes',
        'extension',
        'confirmation_all_changes',
        'other_documents',
        'thesisadviser',
        'notedby',
        'coordinator',
    ];

    protected $casts = [
        'confirmation_all_changes' => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID');
    }

    public function researchInfo()
    {
    return $this->hasOne(ResearchInformation::class, 'user_ID', 'user_ID');
    }
}