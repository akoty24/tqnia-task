<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
use App\Models\Tag;
use App\Services\Api\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function store(TagRequest $request)
    {
        $tag = $this->tagService->createTag($request->validated());
        return response()->json($tag, 201);
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $this->tagService->updateTag($tag, $request->validated());
        return response()->json($tag, 200);
    }

    public function destroy(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        return response()->json(null, 204);
    }
}
