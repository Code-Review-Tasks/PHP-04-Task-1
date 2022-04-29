<?php

namespace App\Services\ShortLinks;

use App\DTO\RequestDTO\ShortLinks\ShortLinksListPostRequestDTO;
use App\DTO\RequestDTO\ShortLinks\ShortLinksPostRequestDTO;
use App\Models\ShortLinks;
use Illuminate\Database\QueryException;

class ShortLinksService
{
    public function saveLinks(ShortLinksListPostRequestDTO $shortLinksListPostRequestDTO)
    {
        /** @var $link ShortLinksPostRequestDTO */
        foreach ($shortLinksListPostRequestDTO->getLinks() as $link) {
            $this->saveLink($link);
        }




//        $insertData = [];
//        /** @var $link ShortLinksPostRequestDTO */
//        foreach ($shortLinksListPostRequestDTO->getLinks() as $link) {
//            $insertData[] = [
//                'long_url' => $link->getLongUrl(),
//                'short_url' => 'ddd',
//                'title' => $link->getTitle(),
//            ];
//        }

//        try {
//            ShortLinks::insert($insertData);
//        } catch (QueryException $e) {
//            if ($e->getCode() === "23505") {
//
//            }
//        }
    }

    public function saveLink(ShortLinksPostRequestDTO $shortLinksPostRequestDTO)
    {
        $issetLink = ShortLinks::where('long_url', $shortLinksPostRequestDTO->getLongUrl())
            ->take(1)
            ->get();

        if ($issetLink->count() > 0) {
            return;
        }



        dd($issetLink->count());
    }
}
