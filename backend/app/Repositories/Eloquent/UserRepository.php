<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class UserRepository implements UserRepositoryInterface
{
    public function login(array $data)
    {

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];


        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new Exception('Email không tồn tại.');
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Exception('Mật khẩu không chính xác.');
        }
        $user['token'] = $token;
        return $user;
    }


    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return $user;

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                throw new Exception('Email already exits',409);
            } else {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function me()
    {
        $user = Auth::user();
        return $user;
    }

    public function logout()
    {
        Auth::logout();
        return true;
    }
}
