<?php

namespace App\Services\Tags;

use App\Models\Tag;

class TagService
{
    public function saveTag(string $name): int
    {
        return Tag::firstOrCreate(['name' => $name])->id;
    }
}
