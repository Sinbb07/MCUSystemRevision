<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedIacuc extends Model
{
    use HasFactory;

    // Fix the table name - add the missing 'u'
    protected $table = 'tbl_approved_iacuc'; // Change this line
    
    protected $primaryKey = 'id';
    
    public $incrementing = true;
    
    protected $keyType = 'int';

    protected $fillable = [
        'user_ID',
        'Protocol_ID',
        'Decision'
    ];

    protected $casts = [
        'Decision' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'Protocol_ID', 'protocol_ID');
    }

    public function scopeApproved($query)
    {
        return $query->where('Decision', 'Approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('Decision', 'Rejected');
    }

    public function isApproved()
    {
        return $this->Decision === 'Approved';
    }

    public function isRejected()
    {
        return $this->Decision === 'Rejected';
    }
}