<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FullBoardModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_full_board_assignments';
    protected $primaryKey = 'assignment_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'assignment_ID',
        'protocol_ID',
        'reviewer_ID',
        'assigned_by',
    ];

    // Relationship: Assignment belongs to a protocol
    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'protocol_ID', 'protocol_ID');
    }

    // Relationship: Assignment belongs to a reviewer (User)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_ID', 'user_ID');
    }

    // Relationship: Assignment was made by a user
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'user_ID');
    }
}
