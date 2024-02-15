<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ForceDeleteOldPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        // Calculate the date 30 days ago
        $thirtyDaysAgo = now()->subDays(30);

        // Get all softly-deleted posts older than 30 days
        $postsToDelete = Post::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->get();

        // Force-delete each post
        foreach ($postsToDelete as $post) {
            $post->forceDelete();
        }
    }

}
