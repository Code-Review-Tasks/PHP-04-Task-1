<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinksRequest;
use App\Services\LinkService;

/**
 * Creates links from POST request
 */
class CreateLinks extends Controller
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
    public function __invoke(CreateLinksRequest $request)
    {
        $data = $request->validated();
        
        $shortUrls = $this->linkService->createLinks($data);
        
        return $shortUrls;
    }
}
