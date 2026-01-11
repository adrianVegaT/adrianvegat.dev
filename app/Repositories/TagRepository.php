<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TagRepository implements TagRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tag::orderBy('name')->get();
    }

    public function findBySlug(string $slug): ?Tag
    {
        return Tag::where('slug', $slug)->first();
    }

    public function create(array $data): Tag
    {
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);
        return $tag->fresh();
    }

    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }

    public function findOrCreateByNames(array $names): Collection
    {
        $tags = collect();

        foreach ($names as $name) {
            $slug = Str::slug($name);
            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))]
            );
            $tags->push($tag);
        }

        return $tags;
    }
}