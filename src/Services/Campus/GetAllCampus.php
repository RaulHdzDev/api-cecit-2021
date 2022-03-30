<?php

namespace App\Services\Campus;

use App\App\Database;

class GetAllCampus
{
    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql = "SELECT * FROM sedes";

            $stmt = $db->prepare($sql);

            $stmt->execute();

            $dbCampus = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return [
                'error'  => false,
                'status' => 200,
                'data'   => (array) $dbCampus
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
