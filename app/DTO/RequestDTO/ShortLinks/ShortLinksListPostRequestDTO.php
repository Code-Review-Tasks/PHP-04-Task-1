<?php

namespace App\DTO\RequestDTO\ShortLinks;

use App\DTO\RequestDTO\RequestDTOInterface;

class ShortLinksListPostRequestDTO implements RequestDTOInterface
{
    private function __construct(
        /** @var $link ShortLinksPostRequestDTO */
        private array $links,
    )
    {}

    public static function makeFromArray(array $data): self
    {
        $result = [];

        foreach ($data as $link) {
            $result[] = ShortLinksPostRequestDTO::makeFromArray($link);
        }

        return new self(
            $result,
        );
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
