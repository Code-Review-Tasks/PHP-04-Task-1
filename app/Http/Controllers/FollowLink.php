<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\Request;

/**
 * Redirects by short link and saves view information in DB
 */
class FollowLink extends Controller
{
    public function __construct(
        private LinkService $linkService
    ) {}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $hash)
    {        
        $link = Link::findByHashOrFail($hash);

        $this->linkService->addVisit($link, $request);

        return redirect($link->long_url, 302);
    }
}
