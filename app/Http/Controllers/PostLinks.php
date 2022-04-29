<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Tag;
use App\Rules\WorkingUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostLinks extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->has(0) ? $request->all() : [$request->all()];

        $validator = Validator::make($data, [
            '*.long_url' => ['bail', 'required', 'url', 'max:2048', new WorkingUrl],
            '*.title' => 'max:255',
            '*.tags.*' => 'max:255|distinct|regex:@[a-z0-9_]+@i'
        ]);

        $validator->validate();
        
        $shortUrls = [];
        foreach ($data as $chunk) {
            $link = new Link(['long_url' => $chunk['long_url']]);

            if ($chunk['title']) {
                $link->title = $chunk['title'];
            }

            $link->save();
            
            foreach ($chunk['tags'] as $tag) {
                $tag = Tag::firstOrNew(['name' => mb_strtolower($tag)]);
                $link->tags()->save($tag);
            }

            $shortUrls[] = $link->hash;
        }
        
        return $shortUrls;
    }
}
