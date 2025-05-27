<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Endpoint\Web\Api;
use App\Endpoint\Web\ReportController;
use App\Endpoint\Web\MonthlySalesByRegionController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\Bootloader\Http\RoutesBootloader as BaseRoutesBootloader;
use Spiral\Cookies\Middleware\CookiesMiddleware;
use Spiral\Csrf\Middleware\CsrfMiddleware;
use Spiral\Debug\Middleware\DumperMiddleware;
use Spiral\Debug\StateCollector\HttpCollector;
use Spiral\Filter\ValidationHandlerMiddleware;
use Spiral\Http\Middleware\ErrorHandlerMiddleware;
use Spiral\Http\Middleware\JsonPayloadMiddleware;
use Spiral\Router\Bootloader\AnnotatedRoutesBootloader;
use Spiral\Router\Loader\Configurator\RoutingConfigurator;
use Spiral\Session\Middleware\SessionMiddleware;
use Nyholm\Psr7\Stream;

/**
 * A bootloader that configures the application's routes and middleware.
 *
 * @link https://spiral.dev/docs/http-routing
 */
final class RoutesBootloader extends BaseRoutesBootloader
{
    protected const DEPENDENCIES = [AnnotatedRoutesBootloader::class];

    protected function globalMiddleware(): array
    {
        return [
            ErrorHandlerMiddleware::class,
            DumperMiddleware::class,
            HttpCollector::class,
        ];
    }

    protected function middlewareGroups(): array
    {
        return [
            'web' => [
                CookiesMiddleware::class,
                SessionMiddleware::class,
                CsrfMiddleware::class,
                ValidationHandlerMiddleware::class
            ],
            'api' => [
                JsonPayloadMiddleware::class
            ]
        ];
    }

    protected function defineRoutes(RoutingConfigurator $routes): void
    {
        // Fallback route for unmatched paths
        $routes->default('/<path:.*>')
            ->callable(function (ServerRequestInterface $r, ResponseInterface $response) {
                return $response->withStatus(404)->withBody(Stream::create('Not found'));
            });
    }
}
