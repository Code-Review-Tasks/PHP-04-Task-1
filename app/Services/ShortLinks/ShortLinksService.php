<?php

namespace App\Services\ShortLinks;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Libs\UrlShortener\UrlShortener;
use App\Models\ShortLink;
use App\Services\Tags\TagService;
use Illuminate\Database\Eloquent\Collection;

class ShortLinksService
{
    public function __construct(
        private TagService $tagService,
        private UrlShortener $urlShortener,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function saveLinks(ShortLinksListPostRequestDTO $shortLinksListPostRequestDTO): Collection
    {
        $result = new Collection();

        foreach ($shortLinksListPostRequestDTO->getLinks() as $link) {
            $result->add($this->saveLink($link));
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function saveLink(ShortLinksPostRequestDTO $shortLinksPostRequestDTO): ShortLink
    {
        $shortLink = new ShortLink();


        $shortLink->long_url = $shortLinksPostRequestDTO->getLongUrl();
        $shortLink->title = $shortLinksPostRequestDTO->getTitle();

        $shortLink->save();

        $shortLink->short_url = $this->urlShortener->encode($shortLink->id, $shortLinksPostRequestDTO->getLongUrl());

        $shortLink->save();

        $tagIds = [];
        foreach ($shortLinksPostRequestDTO->getTags() as $tag) {
            $tagIds[] = $this->tagService->saveTag($tag);
        }

        $shortLink->tags()->sync($tagIds);

        return $shortLink;
    }

    public function updateLink(ShortLinksPostRequestDTO $shortLinksPostRequestDTO, ShortLink $shortLink): ShortLink
    {
        $shortLink->long_url = $shortLinksPostRequestDTO->getLongUrl();
        $shortLink->title = $shortLinksPostRequestDTO->getTitle();

        $tagIds = [];
        foreach ($shortLinksPostRequestDTO->getTags() as $tag) {
            $tagIds[] = $this->tagService->saveTag($tag);
        }

        $shortLink->tags()->sync($tagIds);

        $shortLink->update();

        return $shortLink;
    }

    public function deleteLink(ShortLink $shortLink): void
    {
        $shortLink->delete();
    }

    public function getLinksList(?array $filter): Collection
    {
        $query = ShortLink::with('tags');

        if (isset($filter['title'])) {
            $query->where('title', 'like', '%'.$filter['title'].'%');
        }

        if (isset($filter['tags'])) {
            $query->whereHas('tags', function ($q) use ($filter) {
                $q->whereIn('name', $filter['tags']);
            });
        }

        return $query->get();
    }
}
