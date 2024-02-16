<?php
namespace App\Services\Api;
use App\Models\Tag;
class TagService
{
    public function createTag(array $data): ?Tag
    {
        try {
            $tag = Tag::create($data);
        } catch (\Exception $e) {
            return null;
        }
        return $tag;
    }
    public function updateTag(Tag $tag, array $data): ?Tag
    {
        $tag->update([
            'name' => $data['name'] ?? $tag->name,
        ]);
        return $tag;
    }
    public function deleteTag(Tag $tag): bool
    {
        return $tag->delete();
    }
}
