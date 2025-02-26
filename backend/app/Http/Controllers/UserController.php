<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Responses\BaseResponse;
use Exception;

class UserController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(Request $request)
    {
        try {
            $user = $this->userService->login([
                'email' => $request->email,
                'password' => $request->password
            ]);
            return BaseResponse::success($user, 'Login successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $user = $this->userService->register([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return BaseResponse::success($user, 'Register successfully');
        } catch (Exception $e) {
            return  BaseResponse::error($e->getMessage(),$e->getCode()?:500);
        }
    }

    public function me()
    {
        try {
            $user = $this->userService->me();
            return BaseResponse::success($user, 'Get user successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
    public function logout()
    {
        try {
            $this->userService->logout();
            return BaseResponse::success([], 'Logout successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
