<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchLinkRequest;
use App\Models\Link;
use App\Services\LinkService;

/**
 * Updates link information by hash
 */
class PatchLink extends Controller
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
    public function __invoke(PatchLinkRequest $request, string $hash)
    {
        $link = Link::findByHashOrFail($hash);

        $data = $request->validated();

        $this->linkService->patchLink($link, $data);

        return 'ok';
    }
}
