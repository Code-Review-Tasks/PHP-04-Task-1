<?php

namespace App\Http\Controllers;

use App\Models\ShortLinks;
use App\Services\Statistics\StatisticsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ShortLinksRedirectController extends Controller
{
    public function __construct(
        private StatisticsService $statisticsService,
    ) {
    }

    /**
     * @param ShortLinks $shortLinks
     * @return RedirectResponse|Application|Redirector
     */
    public function checkLink(Request $request, ShortLinks $shortLinks): RedirectResponse|Application|Redirector
    {
        $this->statisticsService->createStat($request, $shortLinks);

        return redirect($shortLinks->long_url);
    }
}
