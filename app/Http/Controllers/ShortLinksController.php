<?php

namespace App\Http\Controllers;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Http\Requests\ShortLinksPostRequest;
use App\Models\ShortLinks;
use App\Services\ShortLinks\ShortLinksService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShortLinksController extends Controller
{

    public function __construct(
        private ShortLinksService $shortLinksService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ShortLinksPostRequest $request)
    {
        $validated = $request->validated();

        $shortLinksListPostRequestDTO = ShortLinksListPostRequestDTO::makeFromArray($validated);

        $this->shortLinksService->saveLinks($shortLinksListPostRequestDTO);

        return response()->json(['success' => 'ok'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShortLinks  $shortLinks
     * @return \Illuminate\Http\Response
     */
    public function show(ShortLinks $shortLinks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShortLinks  $shortLinks
     * @return \Illuminate\Http\Response
     */
    public function edit(ShortLinks $shortLinks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShortLinks  $shortLinks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShortLinks $shortLinks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShortLinks  $shortLinks
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShortLinks $shortLinks)
    {
        //
    }
}
