<?php

namespace App\Services\Statistics;

use App\Models\ShortLink;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticsService
{
    public function getLinkStats(ShortLink $shortLink): array
    {
        $result = Statistic::selectRaw('
            create_date,
            count(id) as total_views,
            count(distinct (ip, user_agent)) as unique_views
        ')
            ->where('short_links_id', $shortLink->id)
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

    public function createStat(Request $request, ShortLink $shortLink): void
    {
        $stat = new Statistic();
        $stat->short_links_id = $shortLink->id;
        $stat->ip = $request->ip();
        $stat->user_agent = md5($request->userAgent());
        $stat->create_date = now();

        $stat->save();
    }
}
