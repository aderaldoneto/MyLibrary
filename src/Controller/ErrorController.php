<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ErrorController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function show(FlattenException $exception, Request $request): Response
    {
        $statusCode = $exception->getStatusCode();

        if ($statusCode >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logger->error('Erro não tratado na aplicação.', [
                'status_code' => $statusCode,
                'path' => $request->getPathInfo(),
                'exception' => $exception,
            ]);
        }

        $template = match ($statusCode) {
            Response::HTTP_FORBIDDEN => 'error/403.html.twig',
            Response::HTTP_NOT_FOUND => 'error/404.html.twig',
            default => 'error/generic.html.twig',
        };

        return $this->render($template, ['statusCode' => $statusCode], new Response(status: $statusCode));
    }
}
