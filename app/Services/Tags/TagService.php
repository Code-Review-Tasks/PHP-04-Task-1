<?php

namespace App\Services\Tags;

use App\Models\Tags;

class TagService
{
    public function saveTag(string $name): int
    {
        $issetTag = Tags::where('name', $name)
            ->take(1)
            ->get();

        if ($issetTag->count() > 0) {
            return $issetTag->first()->id;
        }

        $tag = new Tags();
        $tag->name = $name;

        $tag->save();

        return $tag->id;
    }
}
