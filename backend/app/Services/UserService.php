<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data)
    {
        try {
            return $this->userRepository->login($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register(array $data)
    {
        try {
            return $this->userRepository->register($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
    public function me()
    {
        try {
            return $this->userRepository->me();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function logout()
    {
        try {
            return $this->userRepository->logout();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
