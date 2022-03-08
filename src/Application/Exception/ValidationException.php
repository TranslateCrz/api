<?php

namespace App\Application\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    public function __construct($message = '')
    {
        parent::__construct(400, $message);
    }
}