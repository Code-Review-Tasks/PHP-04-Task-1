<?php

namespace App\Libs\UrlShortener;

class UrlShortener
{
    /**
     * @throws \Exception
     */
    public function encode(int $id, string $url): string
    {
        return md5($id.$url);
    }
}
