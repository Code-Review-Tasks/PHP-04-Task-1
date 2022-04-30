<?php

namespace App\Services\Statistics;

use App\Models\ShortLinks;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticsService
{
    public function getLinkStats(ShortLinks $shortLinks): array
    {
        $result = Statistic::selectRaw('
            create_date,
            count(id) as total_views,
            count(distinct (ip, user_agent)) as unique_views
        ')
            ->where('short_links_id', $shortLinks->id)
            ->groupBy('create_date')
            ->orderBy('create_date', 'desc')
            ->get()->toArray();

        return $result;
    }

    public function getAllStats(): array
    {
        $result = Statistic::with('short_links')->selectRaw('
            short_links_id,
            count(id) as total_views,
            count(distinct (ip, user_agent)) as unique_views
        ')
            ->groupBy('short_links_id')
            ->orderBy('unique_views', 'desc')
            ->get()->toArray();

        return $result;
    }

    public function createStat(Request $request, ShortLinks $shortLinks): void
    {
        $stat = new Statistic();
        $stat->short_links_id = $shortLinks->id;
        $stat->ip = $request->ip();
        $stat->user_agent = $request->userAgent();
        $stat->create_date = \date_create();

        $stat->save();
    }
}
