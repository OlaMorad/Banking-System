<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\registerRequest;
use App\Services\UserRegistrationService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserRegistrationController extends Controller
{
    protected UserRegistrationService $registrationService;

    public function __construct(UserRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * تسجيل مستخدم جديد لأي رول: teller, manager, admin
     */
    public function register(registerRequest $request)
    {
        try {
            $user = $this->registrationService->register(
                $request->only('name', 'email', 'password'),
                $request->role
            );
            $token = JWTAuth::fromUser($user);

            return ApiResponse::sendResponse(201, "User registered successfully with role {$request->role}",[ $user,$token]);
        } catch (\Exception $e) {
            return ApiResponse::sendError($e->getMessage(), 400);
        }}
}
