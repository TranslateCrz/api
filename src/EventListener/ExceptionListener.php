<?php

namespace App\EventListener;

use App\Application\Exception\ExceptionInterface;
use App\View\ErrorView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ExceptionInterface || $exception instanceof HttpException) {
            $response = new Response();
            $response->setContent(json_encode(new ErrorView($exception->getStatusCode(), $exception->getMessage())));
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->add(['Content-Type' => 'application/json']);

            $event->setResponse($response);
        }
    }
}
