<?php

namespace App\Services\Category;

use App\App\Database;

class GetAllCategories
{
    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql = "SELECT * FROM categorias";

            $stmt = $db->prepare($sql);

            $stmt->execute();

            $dbCategories = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return [
                'error'  => false,
                'status' => 200,
                'data'   => (array) $dbCategories
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
