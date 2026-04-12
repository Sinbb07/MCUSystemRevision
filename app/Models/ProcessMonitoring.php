<?php
// app/Models/ProcessMonitoring.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessMonitoring extends Model
{
    use HasFactory;

    protected $table = 'tbl_process_monitoring';

    protected $fillable = [
        'process_code',
        'process_description',
        'user_type', 
        'direction',
        'timestamp',
        'action_by_user_id',
        'action_by_user_type',
        'affected_user_id',
        'affected_user_type',
        'metadata'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'metadata' => 'array'
    ];

    /**
     * Relationship to the user who performed the action
     */
    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by_user_id', 'user_ID');
    }

    /**
     * Relationship to the affected user
     */
    public function affectedUser()
    {
        return $this->belongsTo(User::class, 'affected_user_id', 'user_ID');
    }

    /**
     * Relationship to process definition
     */
    public function definition()
    {
        return $this->belongsTo(ProcessDefinition::class, 'process_code', 'process_code');
    }

    /**
     * Scope for specific user type
     */
    public function scopeForUserType($query, $userType)
    {
        return $query->where('user_type', $userType);
    }

    /**
     * Scope for incoming actions
     */
    public function scopeIncoming($query)
    {
        return $query->where('direction', 'in');
    }

    /**
     * Scope for outgoing actions
     */
    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'out');
    }

    /**
     * Scope to get activities by specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('action_by_user_id', $userId);
    }

    /**
     * Scope to get activities affecting specific user
     */
    public function scopeAffectingUser($query, $userId)
    {
        return $query->where('affected_user_id', $userId);
    }

    /**
     * Scope to get recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('timestamp', '>=', now()->subDays($days));
    }

    /**
     * Scope to get activities by process code
     */
    public function scopeByProcessCode($query, $processCode)
    {
        return $query->where('process_code', $processCode);
    }
}