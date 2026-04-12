<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    use HasFactory;

    protected $table = 'password_reset_otps';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_ID',
        'user_Email', 
        'otp',
        'attempts',
        'expires_at',
        'used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean'
    ];

    // Relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function incrementAttempts()
    {
        $this->increment('attempts');
        return $this;
    }
}
