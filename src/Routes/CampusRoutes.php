<?php

use Slim\App;

$app->get('/campus/get-all', \App\Controllers\CampusController::class . ':getAll');
