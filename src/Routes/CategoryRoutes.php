<?php

use Slim\App;

$app->get('/category/get-all', \App\Controllers\CategoryController::class . ':getAll');
