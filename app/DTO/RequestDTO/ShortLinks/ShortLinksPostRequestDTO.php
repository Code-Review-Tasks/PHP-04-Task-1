<?php

namespace App\DTO\RequestDTO\ShortLinks;

use App\DTO\RequestDTO\RequestDTOInterface;

class ShortLinksPostRequestDTO implements RequestDTOInterface
{
    private function __construct(
        private string $longUrl,
        private ?string $title,
    )
    {}

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['long_url'],
            $data['title'] ?? null,
        );
    }

    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
