<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(array $data)
    {

        $comment = Comment::create([
            'post_id' => $data['post_id'],
            'user_id' => Auth::id(),
            'content' => $data['content'],
            'parent_id' => $data['parent_id'],
        ]);
        return $comment;
    }


    public function update(array $data, $id)
    {

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            throw new Exception('Bạn không có quyền chỉnh sửa bình luận này');
        }
        $comment->update(['content' => $data['content']]);
        return $comment;
    }

    public function delete($id)
    {

        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            throw new Exception('Bạn không có quyền xóa bình luận này');
        }
        if ($comment->replies()->count() > 0) {
            $comment->replies()->delete();
        }
        $comment->delete();

        return true;
    }

    public function getPostID($id)
    {

        $post = Comment::with([
            'user:id,name',
            'replies.user:id,name',
        ])
            ->whereNull('parent_id')
            ->where('post_id', $id)
            ->get();

        return $post;
    }
}
