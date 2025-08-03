<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Otp extends Model
{
    protected $fillable = [
        'ref_no',
        'mobile',
        'otp_code',
        'verification_status',
        'expires_at'
    ];

    public function isExpired()
    {
        return Carbon::now()->gt($this->expires_at);
    }
}
