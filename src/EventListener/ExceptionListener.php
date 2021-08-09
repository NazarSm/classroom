<?php

namespace App\EventListener;

use App\Exception\EntityException;
use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse('Something went wrong', 500);

        if ($exception instanceof NotFoundHttpException) {
            $response = new JsonResponse('Not Found', 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $response = new JsonResponse('Method not allowed', 405);
        }

        if ($exception instanceof EntityException) {
            $response = new JsonResponse($exception->getError(), 422);
        }

        if ($exception instanceof ValidationException) {
            $response = new JsonResponse($exception->getMessages(), 400);
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
}