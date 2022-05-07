<?php

namespace App\DTO\RequestDTO;

interface RequestDTOInterface
{
    public static function makeFromArray(array $data): self;
}
