<?php

namespace App\Middleware;

use Lucent\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Example middleware.
 *
 * Middleware implements PSR-15's MiddlewareInterface. It runs before the
 * controller and can short-circuit the request (return a response early) or
 * pass it on via $handler->handle($request). This example logs each request
 * and adds a header to the response.
 *
 * Attach it to a route group with ->middleware([RequestLogger::class]).
 * This class is a starting point — extend it or delete it as you build.
 */
class RequestLogger implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        Log::channel('requests')->info(
            sprintf('%s %s', $request->getMethod(), $request->getUri()->getPath())
        );

        $response = $handler->handle($request);

        return $response->withHeader('X-Lucent-Middleware', 'RequestLogger');
    }
}