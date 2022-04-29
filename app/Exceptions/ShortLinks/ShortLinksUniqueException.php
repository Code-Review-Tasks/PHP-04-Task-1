<?php

namespace App\Exceptions\ShortLinks;

use Exception;
use Throwable;

class ShortLinksUniqueException extends Exception
{
    public function __construct(string $message = "long_url must be a unique string", int $code, Throwable $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}
