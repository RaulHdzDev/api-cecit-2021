<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Modality\GetAllModalities;

class ModalityController
{
    public function getAll(Request $request, Response $response): Response
    {
        $getAllModalities = new GetAllModalities();
        $response->getBody()->write(json_encode($getAllModalities()));
        return $response;
    }
}
