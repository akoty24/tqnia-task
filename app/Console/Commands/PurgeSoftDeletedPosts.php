<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PurgeSoftDeletedPosts extends Command
{
    
    protected $signature = 'posts:purge';
    protected $description = 'Force-deletes all softly-deleted posts older than 30 days';
    public function handle()
    {
        $posts = Post::onlyTrashed()->where('deleted_at', '<', now()->subDays(30))->get();
        foreach ($posts as $post) {
            $post->forceDelete();
        }

        $this->info('Soft-deleted posts older than 30 days have been force-deleted.');
    }
}
