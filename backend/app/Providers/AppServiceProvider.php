<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau!',
                ], 429);
            });
        });

    }
}
