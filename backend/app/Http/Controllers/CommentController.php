<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Responses\BaseResponse;
use Exception;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function create(Request $request)
    {
        try {
            $comment = $this->commentService->create([
                'post_id' => $request->post_id,
                'content' => $request->content,
                'parent_id' => $request->parent_id,
            ]);
            return BaseResponse::success($comment, 'Comment created successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $comment = $this->commentService->update([
                'post_id' => $request->post_id,
                'content' => $request->content,
                'parent_id' => $request->parent_id,
            ], $id);
            return BaseResponse::success($comment, 'Comment updated successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->commentService->delete($id);
            return BaseResponse::success([], 'Comment deleted successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function getPostID($id)
    {
        try {
            $comment = $this->commentService->getPostID($id);
            return BaseResponse::success($comment, 'Comment retrieved successfully');
        } catch (Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
