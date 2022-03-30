<?php

namespace App\Services\Project;

use App\App\Constants;
use App\App\Database;
use App\Models\AuthorModel;


class UploadRegisterForm
{
    private AuthorModel $author;
    private \Psr\Http\Message\UploadedFileInterface $registerForm;


    public function __construct(array $params)
    {
        $this->author = new authorModel(array(
            'author_id' => $params['author_id']
        ));
        $this->registerForm = $params['register_form'];
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql = "SELECT 
                        proyectos.id_proyectos AS id_proyectos,
                        sedes.sede AS sede,
                        categorias.categoria AS categoria
                    FROM autores 
                    JOIN proyectos 
                        ON autores.id_proyectos = proyectos.id_proyectos
                    JOIN sedes
                        ON proyectos.id_sedes = sedes.id_sedes
                    JOIN categorias
                        ON proyectos.id_categorias = categorias.id_categorias
                    WHERE id_autores = :id_autores";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_autores', $this->author->authorId, \PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            $projectId = $result['id_proyectos'];
            $campus = $result['sede'];
            $category = $result['categoria'];

            $repetitions = 3;
            $divisor = $projectId;

            while (($divisor / 10) >= 1) {
                $divisor = $divisor / 10;
                $repetitions--;
            }

            if ($campus === "El Mante") {
                $campus = "MAN";
            }
            if ($campus === "Nuevo Laredo") {
                $campus = "LAR";
            }

            $folio = "CECIT2021-" . strtoupper(substr($campus, 0, 3)) . "-" . strtoupper(substr($category, 0, 3)) . "-" . str_repeat("0", $repetitions) . $projectId;

            $registerFormDirectory =
                DIRECTORY_SEPARATOR
                . 'register-form';
            $registerFormExtension = pathinfo($this->registerForm->getClientFilename(), PATHINFO_EXTENSION);
            $registerFormBasename = $folio;
            $registerFormFilename = sprintf('%s.%0.8s', $registerFormBasename, $registerFormExtension);
            $this->registerForm->moveTo(Constants::FILE_UPLOAD_BASE_DIR . $registerFormDirectory . DIRECTORY_SEPARATOR . $registerFormFilename);
            $registerFormUrl = $registerFormDirectory . DIRECTORY_SEPARATOR . $registerFormFilename;

            $sql =
                "UPDATE proyectos SET 
                    doc_proyecto = :doc_proyecto,
                    folio = :folio
                WHERE
                    id_proyectos = :id_proyectos;
                ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':doc_proyecto', $registerFormUrl, \PDO::PARAM_STR);
            $stmt->bindParam(':folio', $folio, \PDO::PARAM_STR);
            $stmt->bindParam(':id_proyectos', $projectId, \PDO::PARAM_INT);

            $stmt->execute();

            return [
                'error'  => false,
                'status' => 200,
                'data' => array(
                    'message' => 'Se ha subido el documento con éxito',
                    'folio' => $folio
                )
            ];
        } catch (\Exception $exception) {
            return [
                'error'  => true,
                'status' => 500,
                'data' => array('message' => 'Ocurrió un error en el servidor: ' . $exception->getMessage())
            ];
        }
    }
}
