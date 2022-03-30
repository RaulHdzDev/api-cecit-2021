<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Campus\GetAllCampus;

class CampusController
{
    public function getAll(Request $request, Response $response): Response
    {
        $getAllCampus = new GetAllCampus();
        $response->getBody()->write(json_encode($getAllCampus()));
        return $response;
    }
}
