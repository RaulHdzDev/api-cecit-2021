<?php

use Slim\App;

$app->get('/area/get-all', \App\Controllers\AreaController::class . ':getAll');
