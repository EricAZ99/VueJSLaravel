<?php

namespace App\Http\Controllers\Api\Auth;

use App\Customs\Services\EmailVerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\ResendEmailVerificationRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(private EmailVerificationService $service) {}
    /**
     * Summary of login
     * @param \App\Http\Requests\LoginRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // dd($request);
        // return response()->json([
        //     'status'=>'C\'est quoi ça ?'
        // ]);
        $token = auth()->attempt($request->validated());
        if ($token) {
            return $this->responseWithToken($token, auth()->user());
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Informations d\'identification invalides'
            ], 401);
        }
    }

    /**
     * Resend verification link
     */

    public function resendEmailVerificationLink(ResendEmailVerificationRequest $request)
    {
        return $this->service->resendLink($request->email);
    }

    /**
     * Verify user email
     */

    public function verifyUserEmail(VerifyEmailRequest $request)
    {
        return $this->service->verifiyEmail($request->email, $request->token);
    }

    /**
     * Summary of register
     * @param \App\Http\Requests\RegistrationRequest $request
     * @return void
     */
    public function register(RegistrationRequest $request)
    {
        $user = User::create($request->validated());
        if ($user) {
            $this->service->sendVerificationLink($user);
            $token = auth()->login($user);
            return $this->responseWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Une erreur est survenue lors de l\'enregistrement de l\'utilisateur'
            ], 500);
        }
    }

    /**
     * Summary of responseWithToken
     * @param mixed $token
     * @param mixed $user
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'type' => 'bearer'
        ]);
    }


    public function logout() {
        Auth::logout();
        return response()->json([
            'status'=>'success',
            'message'=>'User has been logged out successfully'
        ]);
    }
}
