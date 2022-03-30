<?php

$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});
