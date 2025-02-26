<?php

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\Request;
use Exception;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function create(array $data)
    {
        try {
            return $this->commentRepository->create($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->commentRepository->update($data, $id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->commentRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getPostID($id)
    {
        try {
            return $this->commentRepository->getPostID($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
