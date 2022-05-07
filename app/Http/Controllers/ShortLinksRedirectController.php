<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
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
     * @param ShortLink $shortLink
     * @return RedirectResponse|Application|Redirector
     */
    public function checkLink(Request $request, ShortLink $shortLink): RedirectResponse|Application|Redirector
    {
        $this->statisticsService->createStat($request, $shortLink);

        return redirect($shortLink->long_url);
    }
}
