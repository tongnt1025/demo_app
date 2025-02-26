<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface CommentRepositoryInterface
{
    public function create(array $data);
    public function update(array $data, $id);

    public function delete($id);
    public function getPostID($id);
}
