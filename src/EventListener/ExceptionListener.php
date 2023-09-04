<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $data  = array();
        $data['message'] = $exception->getMessage();
        $data['errorCode'] = $exception->getMessage();

        // Customize your response object to display the exception details


        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $data['code'] = $exception->getStatusCode();
            $response = new JsonResponse($data);
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

        } else {
            $data['code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = new JsonResponse($data);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}