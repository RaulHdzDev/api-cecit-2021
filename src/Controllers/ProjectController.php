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
        $params = (array)$request->getParsedBody();
        $fecha_inicio = $params['fecha_inicio'];
        $fecha_fin = $params['fecha_fin'];
        try{
            $sql = 'SELECT COUNT(*) as total FROM fechas_proyectos';
            
            $db = new Database();
            $db = $db->connect();
            $result = $db->query($sql);
            $count = $result->fetch()['total'];
            if($count == "0") {
                $sql = 'INSERT INTO fechas_proyectos (fecha_inicio, fecha_fin)
                        VALUES  (:fecha_inicio, :fecha_fin);';
                $result = $db->prepare($sql);
                $result->bindParam(':fecha_inicio', $fecha_inicio);
                $result->bindParam(':fecha_fin', $fecha_fin);
                $result->execute();
                $response->getBody()->write(json_encode(true));
            } else {
                $sql = 'SELECT * FROM fechas_proyectos';
                $result = $db->query($sql);
                $id_fechas_proyectos = $result->fetch()['id_fechas_proyectos'];
                $sql = 'UPDATE fechas_proyectos
                        SET  fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin;
                        WHERE id_fechas_proyectos = :id_fechas_proyectos';
                $result = $db->prepare($sql);
                $result->bindParam(':fecha_inicio', $fecha_inicio);
                $result->bindParam(':fecha_fin', $fecha_fin);
                $result->bindParam(':id_fechas_proyectos', $id_fechas_proyectos);
                $result->execute();
                $response->getBody()->write(json_encode(true));
            }
        } catch(\Exception $exception) {
            echo '{"error": ' . $exception->getMessage() . '}';
        }
        return $response;
    }
}
