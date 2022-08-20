<?php

namespace App\Traits\Auth;

use App\Mail\Auth\EmailVerificationMail;
use App\Models\Auth\EmailVerificationToken;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

trait AuthTrait
{
	/**
	 * Undocumented function
	 *
	 * @param Request $request
	 * @return User
	 */
	public function checkCredentials(Request $request): User
	{
		$user = User::where('email', $request->email)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			throw ValidationException::withMessages([
				'all' => ['The provided credentials are incorrect.'],
			]);
		}

		return $user;
	}

	/**
	 * Register new user
	 *
	 * @param array $userData
	 * @return User
	 */
	public function registerUser(array $userData): User
	{
		$passwordHash = Hash::make($userData['password']);

		$user = User::create([
			'first_name' => $userData['first_name'],
			'last_name'  => $userData['last_name'],
			'email'      => $userData['email'],
			'password'   => $passwordHash,
		]);

		return $user;
	}

	/**
	 * Send email verification with code
	 *
	 * @return boolean
	 */
	public function sendEmailVerification()
	{
		// Check if email is already verified
		if ($this->email_verified_at) {
			abort(406, 'The email is already verified');
		}

		try {
			DB::transaction(function () {
				$code = rand(100000, 999999);
				$lifetime = config('app.auth.email_verification.lifetime', 7200);
				$expiresAt = date('Y-m-d H:i:s', strtotime("+ $lifetime seconds"));

				EmailVerificationToken::updateOrCreate(
					[
						'user_id' => $this->id
					],
					[
						'code' => $code,
						'expires_at' => $expiresAt,
					]
				);

				Mail::to($this->email)->send(new EmailVerificationMail($this, $code, $lifetime));
			});
		} catch (Exception $e) {
			abort(500, $e->getMessage());
		}
	}

	/**
	 * Verify the user verification code
	 *
	 * @param String $verificationCode
	 * @param String $token
	 * @return bool
	 */
	public function verifyEmail(String $verificationCode)
	{
		if ($this->email_verified_at) {
			abort(403, 'The email is already verified');
		}

		$tokenData = EmailVerificationToken::query()
			->where('user_id', $this->id)
			->where('code', $verificationCode)
			->latest()
			->first();

		if (!$tokenData || $tokenData->isExpired()) {
			abort(403, 'Token expired or doesn\'t exist.');
		}

		$this->email_verified_at = strtotime('now');
		$this->save();

		return true;
	}

	/**
	 * Check if user's email is verified or not
	 *
	 * @return boolean
	 */
	public function isEmailVerified()
	{
		if ($this instanceof MustVerifyEmail && !$this->hasVerifiedEmail())
			return false;

		return true;
	}
}
