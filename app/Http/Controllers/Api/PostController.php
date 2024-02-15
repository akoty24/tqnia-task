<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Models\Post;
use App\Services\Api\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getUserPosts(auth()->user());
        return response()->json($posts);
    }

    public function store(PostRequest $request)
    {
        $post = $this->postService->createPost(auth()->user(), $request->validated());
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return response()->json($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $this->postService->updatePost($post, $request->validated());
        return response()->json($post, 200);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->postService->deletePost($post);
        return response()->json(null, 204);
    }

    public function deletedPosts()
    {
        $deletedPosts = $this->postService->getDeletedPosts(auth()->user());
        return response()->json($deletedPosts);
    }

    public function restorePost(Post $post)
    {
        $this->authorize('restore', $post);
        $this->postService->restorePost($post);
        return response()->json($post, 200);
    }
}
