<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use Exception;
use App\Http\Responses\BaseResponse;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function getAll()
    {
        try {
            $posts = $this->postService->getAll();
            return BaseResponse::success($posts, 'Posts retrieved successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function getByID($id)
    {
        try {
            $post = $this->postService->getByID($id);

            if (!$post) {
                return BaseResponse::error('Post not found', 404);
            }

            return BaseResponse::success($post, 'Post retrieved successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $post = $this->postService->create([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return BaseResponse::success($post, 'Post created successfully', 201);
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = $this->postService->update($id, [
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return BaseResponse::success($post, 'Post updated successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->postService->delete($id);

            return BaseResponse::success([], 'Post deleted successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
