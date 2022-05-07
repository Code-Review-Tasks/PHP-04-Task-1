<?php

namespace App\Http\Controllers;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Http\Requests\ShortLinksGetListRequest;
use App\Http\Requests\ShortLinksPatchRequest;
use App\Http\Requests\ShortLinksPostRequest;
use App\Http\Resources\ShortLinkResource;
use App\Models\ShortLink;
use App\Services\ShortLinks\ShortLinksService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShortLinksController extends Controller
{
    public function __construct(
        private ShortLinksService $shortLinksService,
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShortLinksPostRequest $request
     * @return JsonResponse
     */
    public function store(ShortLinksPostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $shortLinksListPostRequestDTO = ShortLinksListPostRequestDTO::makeFromArray($validated);
        $links = $this->shortLinksService->saveLinks($shortLinksListPostRequestDTO);

        return response()->json(ShortLinkResource::collection($links)->toArray($request), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param ShortLink $shortLink
     * @return JsonResponse
     */
    public function show(ShortLink $shortLink): JsonResponse
    {
        return response()->json(new ShortLinkResource($shortLink));
    }

    /**
     * Display the list of resources.
     *
     * @param ShortLinksGetListRequest $request
     * @return JsonResponse
     */
    public function showList(ShortLinksGetListRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $links = $this->shortLinksService->getLinksList($validated);

        return response()->json(
            ShortLinkResource::collection($links)->toArray($request)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShortLinksPatchRequest $request
     * @param ShortLink $shortLink
     * @return JsonResponse
     */
    public function update(ShortLinksPatchRequest $request, ShortLink $shortLink): JsonResponse
    {
        $validated = $request->validated();

        $shortLinksPostRequestDTO = ShortLinksPostRequestDTO::makeFromArray($validated);
        $link = $this->shortLinksService->updateLink($shortLinksPostRequestDTO, $shortLink);

        return response()->json(new ShortLinkResource($link));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShortLink $shortLink
     * @return JsonResponse
     */
    public function destroy(ShortLink $shortLink): JsonResponse
    {
        $this->shortLinksService->deleteLink($shortLink);

        return response()->json(['success' => 'ok']);
    }
}
