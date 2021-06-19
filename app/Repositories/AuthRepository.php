<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function login($data)
    {
        DB::beginTransaction();
        try {
            $validator = Auth::attempt(['email' => $data->email, 'password' => $data->password]);

            if ($validator) {
                $user = Auth::user();
                DB::commit();
                return [
                    'user' => $user,
                    'token' =>  $user->createToken('vuttr')->accessToken
                ];
            }

            DB::rollBack();
            throw new \Exception('Invalid e-mail or password.', null);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), null, $e);
        }
    }

    public function register($data)
    {
        DB::beginTransaction();
        try {
            $user = new User();

            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = bcrypt($data->password);
            $user->save();

            DB::commit();
            return [
                'user' => $user,
                'token' => $user->createToken('vuttr')->accessToken
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), null, $e);
        }
    }
}
