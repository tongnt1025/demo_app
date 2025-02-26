<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;
interface PostRepositoryInterface
{
    public function getAll();
    public function getByID($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
