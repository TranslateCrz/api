<?php

namespace App\Application\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class Exception extends HttpException implements ExceptionInterface
{
    public function __construct($message = 'Invalid parameters', int $code = 400)
    {
        parent::__construct($code, $message);
    }
}
