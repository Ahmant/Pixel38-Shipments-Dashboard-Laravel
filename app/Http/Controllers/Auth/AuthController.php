<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\Auth\AuthTrait;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use AuthTrait;

    /**
     * New user registration
     *
     * @param RegisterRequest $request
     * @return array
     */
    public function register(RegisterRequest $request): array
    {
        try {

            $data = DB::transaction(function () use ($request) {
                $user = $this->registerUser($request->validated());

                event(new Registered($user));

                return [
                    'user_id' => $user->id,
                ];
            });

            return [
                'message' => 'Registred Successfully.',
                'data' => [
                    'user_id' => $data['user_id'],
                ]
            ];
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * User login
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $user = $this->checkCredentials($request);

        if (!$user->isEmailVerified()) {
            return response([
                'error' => true,
                'message' => 'Email verification required',
                'key' => 'email_verification',
                'data' => ['user_id' => $user->id]
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Logged in successfully',
            'data' => [
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'user' => $user
            ]
        ], 200);
    }
}
