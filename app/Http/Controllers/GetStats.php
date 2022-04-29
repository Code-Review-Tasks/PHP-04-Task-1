<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class GetStats extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Link::orderByDesc('unique_views')->get();
    }
}
