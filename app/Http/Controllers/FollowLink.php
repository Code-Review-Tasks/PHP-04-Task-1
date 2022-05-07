<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

/**
 * Redirects by short link and saves view information in DB
 */
class FollowLink extends Controller
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

        $link->visits()->create([
            'ip' => $request->ip(),
            'user_agent_hash' => md5($request->userAgent())
        ]);

        return redirect($link->long_url, 302);
    }
}
