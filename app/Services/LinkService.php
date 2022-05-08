<?php

namespace App\Services;

use App\Http\Resources\LinkCollection;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LinkService
{
    public function createLinks(array $data): array
    {
        $shortUrls = [];
        foreach ($data as $chunk) {
            $link = new Link(['long_url' => $chunk['long_url']]);

            if (!empty($chunk['title'])) {
                $link->title = $chunk['title'];
            }

            $link->save();
            
            if (!empty($chunk['tags'])) {
                $chunk['tags'] = array_unique($chunk['tags']);
                foreach ($chunk['tags'] as $tag) {
                    $tag = Tag::firstOrNew(['name' => mb_strtolower($tag)]);
                    $link->tags()->save($tag);
                }
            }

            $shortUrls[] = $link->hash;
        }

        return $shortUrls;
    }

    public function delete(string $hash): void
    {
        Link::findByHashOrFail($hash)->delete();
    }

    public function addVisit(Link $link, Request $request): void
    {
        $link->visits()->create([
            'ip' => $request->ip(),
            'user_agent_hash' => md5($request->userAgent())
        ]);
    }

    public function getLinks(?string $title, ?string $tag): LinkCollection
    {
        $links = Link::with('tags');

        // Filter by title
        if (!is_null($title)) {
            $links = $links->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", $title);
        }

        // Filter by tag
        if (!is_null($tag)) {
            $links = $links->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('name', $tag);
            });
        }

        return new LinkCollection($links->paginate(10));
    }

    public function getStats(string $hash): Collection
    {
        $link = Link::findByHashOrFail($hash);

        $result = DB::table('visits')->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS day, COUNT(*) AS total_views, COUNT(DISTINCT ip, user_agent_hash) AS unique_views")
            ->where('link_id', $link->id)->groupBy('day')->orderByDesc('day')->get();

        return $result;
    }

    public function getTotalStats(): LinkCollection
    {
        return new LinkCollection(Link::orderByDesc('unique_views')->get());
    }

    public function patchLink(Link $link, array $data): void
    {
        $tagIds = [];
        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => mb_strtolower($tagName)]);
                $tagIds[] = $tag->id;
            }
        }

        $link->tags()->sync($tagIds);

        $link->fill($data)->save();
    }
}