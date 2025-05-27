<?php

declare(strict_types=1);

use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\Environment;
use Nyholm\Psr7\Factory\Psr17Factory;

require "vendor/autoload.php";

$worker = Worker::create();
$psrFactory = new Psr17Factory();
$http = new PSR7Worker(
    $worker,
    $psrFactory,
    $psrFactory,
    $psrFactory
);

$app = require __DIR__ . '/app.php';

while ($req = $http->waitRequest()) {
    try {
        $resp = $app->handle($req);
        $http->respond($resp);
    } catch (\Throwable $e) {
        $http->getWorker()->error((string)$e);
    }
} 