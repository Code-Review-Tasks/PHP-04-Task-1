<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;

/**
 * Returns link views statistics
 */
class GetLinkStats extends Controller
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
        return $this->linkService->getStats($hash);
    }
}
