<?php

namespace App\Services\Area;

use App\App\Database;

class GetAllAreas
{
    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();
        
        try {
            $sql = "SELECT * FROM areas";

            $stmt = $db->prepare($sql);

            $stmt->execute();

            $dbAreas = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return [
                'error'  => false,
                'status' => 200,
                'data'   => (array) $dbAreas
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
