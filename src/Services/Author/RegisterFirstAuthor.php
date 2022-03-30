<?php

namespace App\Services\Author;

use App\App\Database;
use App\Models\AuthorModel;

class RegisterFirstAuthor
{
    private AuthorModel $author;

    public function __construct(array $params)
    {
        $this->author = new AuthorModel($params);
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql =
                "INSERT INTO autores (
                    nombre,
                    ape_pat,
                    ape_mat,
                    domicilio,
                    colonia,
                    cp,
                    curp,
                    rfc,
                    telefono,
                    usuario,
                    email,
                    password,
                    municipio,
                    localidad,
                    escuela,
                    facebook,
                    twitter,
                    nivel_ingles
                ) VALUES (
                    :nombre,
                    :ape_pat,
                    :ape_mat,
                    :domicilio,
                    :colonia,
                    :cp,
                    :curp,
                    :rfc,
                    :telefono,
                    :usuario,
                    :email,
                    :password,
                    :municipio,
                    :localidad,
                    :escuela,
                    :facebook,
                    :twitter,
                    :nivel_ingles
                )";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':nombre', $this->author->name);
            $stmt->bindParam(':ape_pat', $this->author->firstLastName);
            $stmt->bindParam(':ape_mat', $this->author->secondLastName);
            $stmt->bindParam(':domicilio', $this->author->address);
            $stmt->bindParam(':colonia', $this->author->suburb);
            $stmt->bindParam(':cp', $this->author->postalCode);
            $stmt->bindParam(':curp', $this->author->curp);
            $stmt->bindParam(':rfc', $this->author->rfc);
            $stmt->bindParam(':telefono', $this->author->phone);
            $stmt->bindParam(':usuario', $this->author->username);
            $stmt->bindParam(':email', $this->author->email);
            $stmt->bindParam(':password', $this->author->password);
            $stmt->bindParam(':municipio', $this->author->city);
            $stmt->bindParam(':localidad', $this->author->locality);
            $stmt->bindParam(':escuela', $this->author->school);
            $stmt->bindParam(':facebook', $this->author->facebook);
            $stmt->bindParam(':twitter', $this->author->twitter);
            $stmt->bindParam(':nivel_ingles', $this->author->englishLevel);

            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'error'  => true,
                    'status' => 500,
                    'data' => array('message' => 'Ocurrio un error en el servidor: ' . $db->errorInfo()[2])
                ];
            }
            return [
                'error'  => false,
                'status' => 200,
                'data' => array('message' => 'Registro exitoso')
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
