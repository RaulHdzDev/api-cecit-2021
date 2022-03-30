<?php

use Slim\App;

$app->get('/modality/get-all', \App\Controllers\ModalityController::class . ':getAll');
