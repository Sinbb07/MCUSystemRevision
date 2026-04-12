<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchFiles extends Model
{
    protected $table = 'tbl_research_files';

    public $timestamps = true;
    
    protected $fillable = [
        'user_ID',
        'form_id',
        'file_name',
        'file_path',
        'submitted_at',
        'status'
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function form()
    {
        return $this->belongsTo(FormsTable::class, 'form_id', 'form_id');
    }

    /**
     * Scope a query to only include active research files.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive research files.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Soft delete - set status to inactive
     */
    public function softDelete()
    {
        $this->update(['status' => 'inactive']);
    }

    /**
     * Restore - set status to active
     */
    public function restore()
    {
        $this->update(['status' => 'active']);
    }
}