<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Returns link views statistics
 */
class GetLinkStats extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $hash)
    {
        $link = Link::findByHashOrFail($hash);

        $result = DB::table('visits')->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS day, COUNT(*) AS total_views, COUNT(DISTINCT ip, user_agent_hash) AS unique_views")
            ->where('link_id', $link->id)->groupBy('day')->orderByDesc('day')->get();

        return $result;
    }
}
