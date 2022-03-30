<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Category\GetAllCategories;

class CategoryController
{
    public function getAll(Request $request, Response $response): Response
    {
        $getAllCategories = new GetAllCategories();
        $response->getBody()->write(json_encode($getAllCategories()));
        return $response;
    }
}
