<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request, AuthRepository $repository)
    {
        try {
            $model = $repository->register($request);
            return response()->json([
                "user" => new UserResource($model['user']),
                "token" => $model['token']
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function login(AuthLoginRequest $request, AuthRepository  $repository)
    {
        try {
            $model = $repository->login($request);

            return response()->json([
                "user" => new UserResource($model['user']),
                "token" => $model['token']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }
}
