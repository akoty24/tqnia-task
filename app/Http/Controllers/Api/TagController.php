<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\Api\TagService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
class TagController extends Controller
{
    protected $tagService;
    use ApiResponseTrait;
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    // getTags method
    public function index()
    {
        $tags = Tag::all();
        if ($tags->isEmpty()) {
            return $this->errorResponse('No tags found', 404);
        }
        $tagResources = TagResource::collection($tags);
        return $this->successResponse('Tags retrieved successfully', ['data' => $tagResources], 200);
    }
    // storeTag method
    public function store(TagRequest $request)
    {
        $validatedData = $request->validated();
        
        $tag = $this->tagService->createTag($validatedData);
        if (!$tag) {
            return $this->errorResponse('Failed to create tag', 500);
        }
       
            $tag = new TagResource($tag);
        
        return $this->successResponse('Tag created successfully', ['data' => $tag], 201);
    }
    // showTag by id method
    public function show(Tag $tag)
    {
        if (!$tag) {
            return $this->errorResponse('Tag not found', 404);
        }
        $data = [
            'tag' => new TagResource($tag),
        ];
        return $this->successResponse('tag retrieved successfully',  $data, 201);
    }
    // updateTag method
    public function update(TagRequest $request, Tag $tag)
    {
        $this->tagService->updateTag($tag, $request->validated());
        if (!$tag) {
            return $this->errorResponse('Failed to update post', 500);
        }
        $data = [
            'tag' => new TagResource($tag),
        ];
        return $this->successResponse('Tag updated successfully',$data, 201);
    }
    // deleteTag method
    public function destroy(Tag $tag)
    {
        $deleted = $this->tagService->deleteTag($tag);
        if (!$deleted) {
            return $this->errorResponse('Failed to delete tag', 500);
        }
        return $this->successResponse('Tag deleted successfully');
    }
}
