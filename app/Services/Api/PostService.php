<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function getUserPosts(User $user)
    {
        return $user->posts()->with('tags')->orderByDesc('pinned')->latest()->get();
    }

    public function createPost(User $user, array $data): Post
    {
        $post = $user->posts()->create($data);
        if (isset($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }
        return $post;
    }

    public function updatePost(Post $post, array $data): void
    {
        $post->update($data);
        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }
    }

    public function deletePost(Post $post): void
    {
        $post->delete();
    }

    public function getDeletedPosts(User $user)
    {
        return $user->posts()->onlyTrashed()->with('tags')->orderByDesc('pinned')->latest()->get();
    }

    public function restorePost(Post $post): void
    {
        $post->restore();
    }
}
