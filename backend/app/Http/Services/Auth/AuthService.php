<?php

namespace App\Http\Services\Auth;

use App\Http\Repository\UserRepository\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService {
    private $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function register($request): array
    {
        $data = $request->all();

        $pathRole = $request->segment(4);

        if ($pathRole) {
            if ($pathRole != 'user' && $pathRole != 'promoter') {
                $return = [
                    'status' => false,
                    'response' => 'server',
                    'message' => null,
                    'errors' => [
                        'Assign Role from the path is not valid!'
                    ]
                ];

                return $return;
            }
        }

        $return = [];

        $findByEmail = $this->userInterface->detailByEmail($data['email']);

        if ($findByEmail) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Email has already register'
                ]
            ];
        }
        else {
            $data['password'] = Hash::make($data['password']);
            $user = $this->userInterface->create($data);

            $return = [
                'status' => true,
                'response' => 'created',
                'data' => $user
            ];
        }


        return $return;

    }

    public function login($data): array
    {
        $return = [];

        $findByEmail = $this->userInterface->detailByEmail($data['email']);

        if (!$findByEmail) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => ['Email or Password is incorrect!']
            ];

            return $return;
        }

        $checkPassword = Hash::check($data['password'], $findByEmail->password);
        if(!$checkPassword) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => ["Email or Password is incorrect!"]
            ];

            return $return;
        }

        $token = JWTAuth::attempt($data);
        if (!$token) {
            $return = [
                'status' => false,
                'response' => 'server',
                'data' => null,
                'message' => null,
                'errors' => null
            ];

            return $return;
        }

        $user = JWTAuth::user();

        $resultData = [
            'authorization' => [
                'type' => 'Bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'token' => $token
            ],
            'user' => $user
        ];

        $return = [
            'status' => true,
            'response' => 'login',
            'data' => $resultData,
            'message' => 'Successfully Login!'
        ];
    

    return $return;

    }

    public function logout($request): array
    {
        Auth::logout();
        JWTAuth::invalidate($request->bearerToken());

        $return = [
            'status' => true,
            'response' => 'logout',
            'data' => null,
            'message' => 'Successfully Logout!'
        ];

        return $return;
    }
}
