<?php

namespace App\Libs\UrlShortener;

class UrlShortener
{
    /**
     * @throws \Exception
     */
    public function encode(string $url): string
    {
        $padding = random_int(0, 10);
        return mb_substr(md5($url), $padding, 10);
    }
}
