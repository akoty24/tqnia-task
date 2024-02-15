<?php

namespace App\Services\Api;

use App\Models\Tag;

class TagService
{

    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }
    public function updateTag(Tag $tag, array $data): void
    {
        $tag->update($data);
    }

    public function deleteTag(Tag $tag): void
    {
        $tag->delete();
    }
}
