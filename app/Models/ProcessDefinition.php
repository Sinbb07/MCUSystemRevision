<?php
// app/Models/ProcessDefinition.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessDefinition extends Model
{
    use HasFactory;

    protected $table = 'tbl_process_definitions';

    protected $fillable = [
        'process_code',
        'process_description', 
        'user_type',
        'direction',
        'sequence_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all monitoring records for this process definition
     */
    public function monitoringRecords()
    {
        return $this->hasMany(ProcessMonitoring::class, 'process_code', 'process_code');
    }

    /**
     * Scope to get only active processes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get processes for specific user type
     */
    public function scopeForUserType($query, $userType)
    {
        return $query->where('user_type', $userType);
    }

    /**
     * Scope to get processes by direction
     */
    public function scopeByDirection($query, $direction)
    {
        return $query->where('direction', $direction);
    }
}