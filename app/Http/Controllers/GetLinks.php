<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GetLinks extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $links = Link::with('tags');

        // Filter by title
        if ($request->has('title')) {
            $links = $links->where('title', 'like', "%$request->title%");
        }

        // Filter by tag
        if ($request->has('tag')) {
            $links = $links->whereHas('tags', function (Builder $query) use ($request) {
                $query->where('name', $request->tag);
            });
        }

        return $links->paginate(10);
    }
}
