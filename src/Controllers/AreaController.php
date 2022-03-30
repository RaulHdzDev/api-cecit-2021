<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Area\GetAllAreas;

class AreaController
{
    public function getAll(Request $request, Response $response): Response
    {
        $getAllAreas = new GetAllAreas();
        $response->getBody()->write(json_encode($getAllAreas()));
        return $response;
    }
}
