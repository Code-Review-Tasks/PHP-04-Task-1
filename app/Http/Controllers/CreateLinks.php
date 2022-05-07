<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinksRequest;
use App\Models\Link;
use App\Models\Tag;

/**
 * Creates links from POST request
 */
class CreateLinks extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateLinksRequest $request)
    {
        $data = $request->validated();
        
        $shortUrls = [];
        foreach ($data as $chunk) {
            $link = new Link(['long_url' => $chunk['long_url']]);

            if (!empty($chunk['title'])) {
                $link->title = $chunk['title'];
            }

            $link->save();
            
            if (!empty($chunk['tags'])) {
                $chunk['tags'] = array_unique($chunk['tags']);
                foreach ($chunk['tags'] as $tag) {
                    $tag = Tag::firstOrNew(['name' => mb_strtolower($tag)]);
                    $link->tags()->save($tag);
                }
            }

            $shortUrls[] = $link->hash;
        }
        
        return $shortUrls;
    }
}
