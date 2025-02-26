<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;


class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }
    public function getByID($id)
    {
        try {
            return $this->postRepository->getByID($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create(array $data)
    {
        try{
            return $this->postRepository->create($data);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function update($id, array $data)
    {
        try {
            return $this->postRepository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->postRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
