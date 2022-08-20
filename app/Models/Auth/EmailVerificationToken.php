<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerificationToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'code', 'expires_at'];

    public function isExpired() {
        return $this->expires_at > date('now');
    }
}
