<?php

namespace App\Http\Controllers;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Http\Requests\ShortLinksGetListRequest;
use App\Http\Requests\ShortLinksPatchRequest;
use App\Http\Requests\ShortLinksPostRequest;
use App\Models\ShortLinks;
use App\Services\ShortLinks\ShortLinksService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShortLinksController extends Controller
{

    public function __construct(
        private ShortLinksService $shortLinksService,
    )
    {
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

        $this->shortLinksService->saveLinks($shortLinksListPostRequestDTO);

        return response()->json(['success' => 'ok'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param ShortLinks $shortLinks
     * @return JsonResponse
     */
    public function show(ShortLinks $shortLinks): JsonResponse
    {
        return response()->json($shortLinks->toArray());
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

        return response()->json(
            $this->shortLinksService->getLinksList($validated)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShortLinksPatchRequest $request
     * @param ShortLinks $shortLinks
     * @return JsonResponse
     */
    public function update(ShortLinksPatchRequest $request, ShortLinks $shortLinks): JsonResponse
    {
        $validated = $request->validated();

        $shortLinksPostRequestDTO = ShortLinksPostRequestDTO::makeFromArray($validated);

        $this->shortLinksService->updateLink($shortLinksPostRequestDTO, $shortLinks);

        return response()->json(['success' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShortLinks $shortLinks
     * @return JsonResponse
     */
    public function destroy(ShortLinks $shortLinks): JsonResponse
    {
        $this->shortLinksService->deleteLink($shortLinks);

        return response()->json(['success' => 'ok']);
    }
}
