<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StatsService
{
    // getStats
    public function getStats()
    {
        return Cache::remember('stats', now()->addMinutes(60), function () {
            $userCount = User::count();
            $postCount = Post::count();
            $usersWithZeroPostsCount = User::whereDoesntHave('posts')->count();

            return [
                'user_count' => $userCount,
                'post_count' => $postCount,
                'users_with_zero_posts_count' => $usersWithZeroPostsCount,
            ];
        });
    }
// updateStatsCache
    public function updateStatsCache()
    {
        Cache::forget('stats');
        $this->getStats();
    }
}