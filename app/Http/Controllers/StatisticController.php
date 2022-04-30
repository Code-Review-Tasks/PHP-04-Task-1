<?php

namespace App\Http\Controllers;

use App\Models\ShortLinks;
use App\Services\Statistics\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    public function __construct(
        private StatisticsService $statisticsService,
    )
    {
    }

    /**
     * @param ShortLinks $shortLinks
     * @return JsonResponse
     */
    public function getLinkStats(ShortLinks $shortLinks): JsonResponse
    {
        $linkStats = $this->statisticsService->getLinkStats($shortLinks);
        return response()->json($linkStats);
    }

    /**
     * @param ShortLinks $shortLinks
     * @return JsonResponse
     */
    public function getAllStats(): JsonResponse
    {
        $linkStats = $this->statisticsService->getAllStats();
        return response()->json($linkStats);
    }
}
