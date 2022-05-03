<?php

namespace App\View;

class ErrorView
{
    public int $statusCode;
    public string $message;

    public function __construct(int $statusCode, string $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }
}
