<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    public function create(array $data)
    {

        $post = Post::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);
        Cache::forget('posts_list');
        return $post;
    }
    public function update($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        Cache::forget('posts_list');
        return $post;
    }
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        Cache::forget('posts_list');
        return true;
    }


    public function getAll()
    {
        return Cache::remember('posts_list', 300, function () {
            return Post::select('id', 'title', 'content', 'created_at')
                ->orderByDesc('created_at')
                ->get();
        });
    }

    public function getById($id)
    {
        return Post::select('id', 'title', 'content', 'created_at')
            ->where('id', $id)
            ->first();
    }
}
