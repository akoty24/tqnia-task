<?php

namespace App\Services\Api;

use App\Models\Post;
use App\Models\User;
use App\Traits\HandlesImages;

class PostService
{
    use HandlesImages;
    //get all posts of a user
    public function getUserPosts(User $user)
    {
        return $user->posts()->with('tags')->orderByDesc('pinned')->latest()->get();    
    }

    public function createPost(User $user, array $data): Post
    {
        $imagePath = $this->storeImage($data['cover_image']);
        
        // Create the post
        $post = $user->posts()->create([
            'title' => $data['title'],
            'body' => $data['body'],
            'cover_image' => $imagePath,
            'pinned' => $data['pinned'],
        ]);
    
        if (isset($data['tags']) && is_array($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }
    
        return $post;

    }

    public function updatePost(Post $post, array $data)
{
            $imagePath = $this->storeImage($data['cover_image']);
            
    if (isset($data['cover_image'])) {
        $imagePath = $data['cover_image']->store('public/post_images');
        $imagePath = str_replace('public/', 'storage/', $imagePath);
    }
    
    $post->update([
        'title' => $data['title'] ?? $post->title,
        'body' => $data['body'] ?? $post->body, 
        'cover_image' => $imagePath, 
        'pinned' => $data['pinned'] ?? $post->pinned,
    ]);

    if (isset($data['tags']) && is_array($data['tags'])) {
        $post->tags()->sync($data['tags']);
    }

    return $post;
}

    public function deletePost(Post $post)
    {
        $post->delete();
    }

    public function getDeletedPosts(User $user)
    {
        return $user->posts()->onlyTrashed()->get();

    }

    public function restorePost(Post $post)
    {

        $post->restore();
        
    }
}
