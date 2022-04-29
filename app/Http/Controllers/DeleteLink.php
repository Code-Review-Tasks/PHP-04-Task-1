<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class DeleteLink extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $hash)
    {
        if (is_null($link = Link::findByHash($hash))) {
            throw new ModelNotFoundException("$hash not found");
        }

        $link->delete();

        return 'ok';
    }
}
