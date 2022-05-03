<?php

namespace App\Application\Exception;

interface ExceptionInterface
{
    public function getStatusCode();

    public function getMessage();
}
