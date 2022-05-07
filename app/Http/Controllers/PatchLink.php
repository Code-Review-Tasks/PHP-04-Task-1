<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Tag;
use App\Rules\WorkingUrl;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
    public function __invoke(Request $request, string $hash)
    {
        $link = Link::findByHashOrFail($hash);

        $data = $request->validate([
            'long_url' => ['bail', 'required', 'url', 'max:2048', new WorkingUrl],
            'title' => 'max:255',
            'tags.*' => 'max:255|distinct|regex:@[a-z0-9_]+@i'
        ]);

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
