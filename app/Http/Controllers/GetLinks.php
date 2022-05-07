<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLinksRequest;
use App\Http\Resources\LinkCollection;
use App\Models\Link;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Returns all links
 */
class GetLinks extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GetLinksRequest $request)
    {
        $links = Link::with('tags');

        // Filter by title
        if ($request->has('title')) {
            $links = $links->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", $request->title);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $links = $links->whereHas('tags', function (Builder $query) use ($request) {
                $query->where('name', $request->tag);
            });
        }

        return new LinkCollection($links->paginate(10));
    }
}
