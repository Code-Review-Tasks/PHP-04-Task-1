<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Services\Statistics\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    public function __construct(
        private StatisticsService $statisticsService,
    ) {
    }

    /**
     * @param ShortLink $shortLink
     * @return JsonResponse
     */
    public function getLinkStats(ShortLink $shortLink): JsonResponse
    {
        $linkStats = $this->statisticsService->getLinkStats($shortLink);

        return response()->json($linkStats);
    }

    /**
     * @return JsonResponse
     */
    public function getAllStats(): JsonResponse
    {
        $linkStats = $this->statisticsService->getAllStats();

        return response()->json($linkStats);
    }
}
