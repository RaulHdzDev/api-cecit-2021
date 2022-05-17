<?php

$app->post('/project/create-one-author', \App\Controllers\ProjectController::class . ':createOneAuthor');
$app->post('/project/create-two-authors', \App\Controllers\ProjectController::class . ':createTwoAuthors');
$app->post('/project/upload-register-form', \App\Controllers\ProjectController::class . ':uploadRegisterForm');
$app->post('/project/get-project-info', \App\Controllers\ProjectController::class . ':getProjectInfo');
$app->post('/project/upload-image', \App\Controllers\ProjectController::class . ':uploadImage');
$app->get('/project/obtener-fechas', \App\Controllers\ProjectController::class . ':fechas');
