<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Assessor\UploadImage;

class AssessorController
{
    public function uploadImage(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $files = $request->getUploadedFiles();
        $params['image_ine'] = $files['image_ine'] ?? '';
        $uploadImage = new UploadImage($params);
        $response->getBody()->write(json_encode($uploadImage()));
        return $response;
    }
}
