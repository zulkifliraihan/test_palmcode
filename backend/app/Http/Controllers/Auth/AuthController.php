<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $registerRequest) {

         try {
            $authService = $this->authService->register($registerRequest);

            if (!$authService['status']) {
                if ($authService['response'] == "validation") {
                    return $this->errorvalidator($authService['errors'], $authService['message']);
                }
                else {
                    return $this->errorServer($authService['errors']);
                }
            }

            return $this->success(
                $authService['response'],
                $authService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $authService = $this->authService->login( $request->all());


            if (!$authService['status']) {
                if ($authService['response'] == "validation") {
                    return $this->errorvalidator($authService['errors'], $authService['message']);
                }
                else {
                    return $this->errorServer($authService['errors']);
                }
            }

            return $this->success(
                $authService['response'],
                $authService['data'],
                $authService['message']
            );
        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $authService = $this->authService->logout($request);

            return $this->success(
                $authService['response'],
                $authService['data'],
                $authService['message']
            );
        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }
}
