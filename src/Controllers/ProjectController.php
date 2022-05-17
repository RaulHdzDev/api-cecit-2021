<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\Project\RegisterProjectOneAuthor;
use App\Services\Project\RegisterProjectTwoAuthors;
use App\Services\Project\UploadRegisterForm;
use App\Services\Project\GetProjectInfo;
use App\Services\Project\UploadImage;

use App\App\Constants;
use App\App\Database;

class ProjectController
{
    public function createOneAuthor(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $files = $request->getUploadedFiles();
        $params['image_ine'] = $files['image_ine'] ?? '';
        $params['project_image'] = $files['project_image'] ?? '';
        $registerProjectOneAuthor = new RegisterProjectOneAuthor($params);
        $response->getBody()->write(json_encode($registerProjectOneAuthor()));
        return $response;
    }

    public function createTwoAuthors(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $files = $request->getUploadedFiles();
        $params['image_ine'] = $files['image_ine'] ?? '';
        $params['project_image'] = $files['project_image'] ?? '';
        $registerProjectTwoAuthors = new RegisterProjectTwoAuthors($params);
        $response->getBody()->write(json_encode($registerProjectTwoAuthors()));
        return $response;
    }

    public function uploadRegisterForm(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $files = $request->getUploadedFiles();
        $params['register_form'] = $files['register_form'];
        $uploadRegisterForm = new UploadRegisterForm($params);
        $response->getBody()->write(json_encode($uploadRegisterForm()));
        return $response;
    }

    public function getProjectInfo(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $getProjectInfo = new GetProjectInfo($params);
        $response->getBody()->write(json_encode($getProjectInfo()));
        return $response;
    }

    public function uploadImage(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        $files = $request->getUploadedFiles();
        $params['project_image'] = $files['project_image'] ?? '';
        $uploadImage = new UploadImage($params);
        $response->getBody()->write(json_encode($uploadImage()));
        return $response;
    }

    public function fechas(Request $request, Response $response): Response
    {
        $sql = "SELECT fechas_proyectos.fecha_inicio, fechas_proyectos.fecha_fin 
        FROM fechas_proyectos";
        try{
            $db = new DataBase();
            $db = $db->connect();
        
            $result = $db->query($sql);
        
            if($result->rowCount() > 0) {
                echo json_encode($result->fetch());
            }
        } catch(\Exception $e) {
            echo '{"error": ' . $e->getMessage() . '}';
        }
        return $response;
    }
}
