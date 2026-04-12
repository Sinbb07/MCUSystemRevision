<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedIacuc extends Model
{
    use HasFactory;

    protected $table = 'tbl_approved_iacuc';
    
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

    /**
     * Get the user that owns the approval
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    /**
     * Get the protocol that was approved
     */
    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'Protocol_ID', 'protocol_ID');
    }

    /**
     * Scope for approved protocols
     */
    public function scopeApproved($query)
    {
        return $query->where('Decision', 'Approved');
    }

    /**
     * Scope for rejected protocols
     */
    public function scopeRejected($query)
    {
        return $query->where('Decision', 'Rejected');
    }

    /**
     * Check if protocol is approved
     */
    public function isApproved()
    {
        return $this->Decision === 'Approved';
    }

    /**
     * Check if protocol is rejected
     */
    public function isRejected()
    {
        return $this->Decision === 'Rejected';
    }
}