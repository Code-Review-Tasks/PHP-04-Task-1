<?php

namespace App\Services\ShortLinks;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Libs\UrlShortener\UrlShortener;
use App\Models\ShortLinks;
use App\Services\Tags\TagService;

class ShortLinksService
{
    public function __construct(
        private TagService $tagService,
    ) {
    }

    public function saveLinks(ShortLinksListPostRequestDTO $shortLinksListPostRequestDTO): void
    {
        /** @var $link ShortLinksPostRequestDTO */
        foreach ($shortLinksListPostRequestDTO->getLinks() as $link) {
            $this->saveLink($link);
        }
    }

    /**
     * @throws \Exception
     */
    public function saveLink(ShortLinksPostRequestDTO $shortLinksPostRequestDTO): void
    {
        $issetLink = ShortLinks::where('long_url', $shortLinksPostRequestDTO->getLongUrl())
            ->take(1)
            ->get();

        if ($issetLink->count() > 0) {
            $shortLink = $issetLink->first();
        } else {
            $shortLink = new ShortLinks();
            $shortLink->short_url = (new UrlShortener())->encode($shortLinksPostRequestDTO->getLongUrl());
        }

        $shortLink->long_url = $shortLinksPostRequestDTO->getLongUrl();
        $shortLink->title = $shortLinksPostRequestDTO->getTitle();

        $shortLink->save();

        $tagIds = [];
        foreach ($shortLinksPostRequestDTO->getTags() as $tag) {
            $tagIds[] = $this->tagService->saveTag($tag);
        }

        $shortLink->tags()->sync($tagIds);
    }

    public function updateLink(ShortLinksPostRequestDTO $shortLinksPostRequestDTO, ShortLinks $shortLink): void
    {
        $shortLink->long_url = $shortLinksPostRequestDTO->getLongUrl();
        $shortLink->title = $shortLinksPostRequestDTO->getTitle();

        $tagIds = [];
        foreach ($shortLinksPostRequestDTO->getTags() as $tag) {
            $tagIds[] = $this->tagService->saveTag($tag);
        }

        $shortLink->tags()->sync($tagIds);

        $shortLink->update();
    }

    public function deleteLink(ShortLinks $shortLink): void
    {
        $shortLink->delete();
    }

    public function getLinksList(?array $filter): array
    {
        $query = ShortLinks::with('tags');

        if (isset($filter['title'])) {
            $query->where('title', $filter['title']);
        }

        if (isset($filter['tags'])) {
            $query->whereHas('tags', function ($q) use ($filter) {
                $q->whereIn('name', $filter['tags']);
            });
        }

        return $query->get()->toArray();
    }
}
