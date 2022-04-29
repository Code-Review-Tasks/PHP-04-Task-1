<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

/**
 * Deletes link by hash
 */
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
        $link = Link::findByHashOrFail($hash)->delete();

        return 'ok';
    }
}
