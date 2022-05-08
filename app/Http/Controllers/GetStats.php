<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;

/**
 * Returns all links sorted by unique views
 */
class GetStats extends Controller
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
    public function __invoke(Request $request)
    {
        return $this->linkService->getTotalStats();
    }
}
