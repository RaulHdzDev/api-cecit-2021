<?php

namespace App\Services\Project;

use App\App\Constants;
use App\App\Database;
use App\Models\AssessorModel;
use App\Models\AuthorModel;
use App\Models\ProjectModel;


class GetProjectInfo
{
    private AssessorModel $assessor;
    private AuthorModel $firstAuthor;
    private ProjectModel $project;

    public function __construct(array $params)
    {
        $this->firstAuthor = new AuthorModel(array(
            'author_id' => $params['author_id']
        ));
    }

    public function __invoke(): array
    {
        $db = new Database();
        $db = $db->connect();

        try {
            $sql =
                "SELECT 
                asesores.nombre AS nombre_asesor,
                asesores.ape_pat AS ape_pat_asesor,
                asesores.ape_mat AS ape_mat_asesor,
                asesores.domicilio AS domicilio_asesor,
                asesores.colonia AS colonia_asesor,
                asesores.cp AS cp_asesor,
                asesores.curp AS curp_asesor,
                asesores.rfc AS rfc_asesor,
                asesores.telefono AS telefono_asesor,
                asesores.email AS email_asesor,
                asesores.municipio AS municipio_asesor,
                asesores.localidad AS localidad_asesor,
                asesores.escuela AS escuela_asesor,
                asesores.facebook AS facebook_asesor,
                asesores.twitter AS twitter_asesor,
                proyectos.descripcion_asesor AS descripcion_asesor,
                asesores.img_ine AS img_ine_asesor,
                proyectos.id_proyectos AS id_proyectos,
                proyectos.id_categorias AS id_categorias,
                proyectos.id_modalidades AS id_modalidades,
                proyectos.id_sedes AS id_sedes,
                proyectos.id_areas AS id_areas,
                proyectos.nombre AS nombre_proyecto,
                proyectos.descripcion AS descripcion_proyecto,
                proyectos.url AS url_proyecto,
                proyectos.imagen AS imagen_proyecto,
                proyectos.folio AS folio_proyecto
            FROM autores 
            JOIN proyectos 
                ON autores.id_proyectos = proyectos.id_proyectos
            LEFT JOIN asesores
                ON proyectos.id_asesores = asesores.id_asesores
            WHERE id_autores = :id_autores";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_autores', $this->firstAuthor->authorId, \PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            $sql =
                "SELECT 
                nombre AS nombre_segundo_autor,
                ape_pat AS ape_pat_segundo_autor,
                ape_mat AS ape_mat_segundo_autor,
                domicilio AS domicilio_segundo_autor,
                colonia AS colonia_segundo_autor,
                cp AS cp_segundo_autor,
                curp AS curp_segundo_autor,
                rfc AS rfc_segundo_autor,
                telefono AS telefono_segundo_autor,
                email AS email_segundo_autor,
                municipio AS municipio_segundo_autor,
                localidad AS localidad_segundo_autor,
                escuela AS escuela_segundo_autor,
                facebook AS facebook_segundo_autor,
                twitter AS twitter_segundo_autor,
                nivel_ingles AS nivel_ingles_segundo_autor
            FROM autores 
            WHERE id_autores != :id_autores
            AND id_proyectos = :id_proyectos";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_autores', $this->firstAuthor->authorId, \PDO::PARAM_INT);
            $stmt->bindParam(':id_proyectos', $result['id_proyectos'], \PDO::PARAM_INT);

            $stmt->execute();

            $secondAuthor = $stmt->fetch(\PDO::FETCH_ASSOC);

            $result['segundo_autor'] = $secondAuthor;

            return [
                'error'  => false,
                'status' => 200,
                'data' => $result
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
