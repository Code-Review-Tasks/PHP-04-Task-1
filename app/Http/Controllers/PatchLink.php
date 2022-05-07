<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchLinkRequest;
use App\Models\Link;
use App\Models\Tag;

/**
 * Updates link information by hash
 */
class PatchLink extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PatchLinkRequest $request, string $hash)
    {
        $link = Link::findByHashOrFail($hash);

        $data = $request->validated();

        $tagIds = [];
        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => mb_strtolower($tagName)]);
                $tagIds[] = $tag->id;
            }
        }

        $link->tags()->sync($tagIds);

        $link->fill($data)->save();

        return 'ok';
    }
}
