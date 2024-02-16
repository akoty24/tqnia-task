<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Api\PostService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;
    use ApiResponseTrait;


    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    // get all posts
    public function index()
    {
        $user = Auth::guard('api')->user();
        $posts = $this->postService->getUserPosts($user);
       if ($posts->isEmpty()) {
            return $this->errorResponse('No Posts found', 404);
        }
        $PostResources = PostResource::collection($posts);

        return $this->successResponse('Posts retrieved successfully', ['data' => $PostResources], 200);
    }
// storePost
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::guard('api')->user();
        $post = $this->postService->createPost($user,$validatedData);
        if (!$post) {
            return $this->errorResponse('Failed to create Post', 500);
        }
        $data = [
            'post' => new PostResource($post),
        ];
        return $this->successResponse('Post created successfully', $data, 201);
    }
// showPost by id
    public function show(Post $post)
    {
        $user = Auth::guard('api')->user();
    if ($user->id !== $post->user_id) {
        return $this->errorResponse('Unauthorized', 401);
    }

    return $this->successResponse('Post retrieved successfully', ['data' => new PostResource($post)], 200);
    }
// updatePost
    public function update(PostRequest $request, Post $post)
    {
        $validatedData = $request->validated();
        $user = Auth::guard('api')->user();
    
        if ($user->id !== $post->user_id) {
            return $this->errorResponse('Unauthorized', 401);
        }
    
        $this->postService->updatePost($post, $validatedData);
    
        $data = [
            'post' => new PostResource($post),
        ];
    
        return $this->successResponse('Post updated successfully', $data, 200);
    }
// deletePost
    public function destroy(Post $post)
    {
       $user = Auth::guard('api')->user();
    if ($user->id !== $post->user_id) {
        return $this->errorResponse('Unauthorized', 401);
    }
    $this->postService->deletePost($post);

    return $this->successResponse('Post deleted successfully', null, 200);
    }

    // get deleted posts
    public function deletedPosts()
    {
        $user = Auth::guard('api')->user();

        $deletedPosts = $this->postService->getDeletedPosts($user);
    
        return $this->successResponse('Deleted posts retrieved successfully', ['data' => PostResource::collection($deletedPosts)], 200);
    }
// restore deleted Post
   public function restorePost($id)
{
    $post = Post::withTrashed()->find($id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    // Check if the authenticated user is the owner of the post
    if (Auth::guard('api')->user()->id !== $post->user_id) {
        return response()->json(['message' => 'Unauthorized to restore this post'], 403);
    }

    if (!$post->trashed()) {
        return response()->json(['message' => 'The post is not deleted'], 400);
    }
    $post->restore();
    $data = [
        'post' => new PostResource($post),
    ];
    return $this->successResponse('Post restored successfully', $data, 200);

    }
}
