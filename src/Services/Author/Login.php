<?php

namespace App\Services\Author;

use App\App\Database;
use App\Models\AuthorModel;

class Login
{
    private AuthorModel $author;

    public function __construct(array $params)
    {
        $newParams = array('user_name' => $params['user'], 'password' => $params['password']);
        $this->author = new AuthorModel($newParams);
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql =
                "SELECT * FROM autores
                WHERE
                    usuario = :usuario
            ";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':usuario', $this->author->username);

            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'error'  => true,
                    'status' => 404,
                    'data' => array('message' => 'No se encontró la cuenta de usuario')
                ];
            }

            $dbAuthor = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($this->author->password != $dbAuthor->password) {
                return [
                    'error'  => true,
                    'status' => 500,
                    'data' => array('message' => 'La contraseña es incorrecta')
                ];
            }

            return [
                'error'  => false,
                'status' => 200,
                'data'   => (array) $dbAuthor
            ];
        } catch (\Exception $exception) {
            return [
                'error'  => true,
                'status' => 500,
                'data' => array('message' => 'Ocurrio un error en el servidor: ' . $exception->getMessage())
            ];
        }
    }
}
