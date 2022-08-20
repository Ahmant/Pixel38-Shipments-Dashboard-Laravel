<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify (EmailVerificationRequest $request, User $user) {
        $user->verifyEmail($request->verification_code);
        
        return [
            'message' => 'Email verified successfully'
        ];
    }
}
