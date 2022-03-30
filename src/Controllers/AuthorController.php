<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Author\RegisterFirstAuthor;
use App\Services\Author\Login;

class AuthorController
{
    public function create(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        $registerFirstAuthor = new RegisterFirstAuthor($params);

        $response->getBody()->write(json_encode($registerFirstAuthor()));
        return $response;
    }

    public function login(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        $login = new Login($params);

        $response->getBody()->write(json_encode($login()));
        return $response;
    }
}
