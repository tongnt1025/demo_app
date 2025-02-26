<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function register(array $data);
    public function login(array $data);
    public function me();
    public function logout();
}
