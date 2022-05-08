<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLinksRequest;
use App\Services\LinkService;

/**
 * Returns all links
 */
class GetLinks extends Controller
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
    public function __invoke(GetLinksRequest $request)
    {
        return $this->linkService->getLinks($request->input('title'), $request->input('tag'));
    }
}
