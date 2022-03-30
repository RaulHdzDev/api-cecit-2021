<?php

use Slim\App;

$app->post('/author/create', \App\Controllers\AuthorController::class . ':create');
$app->post('/author/login', \App\Controllers\AuthorController::class . ':login');
