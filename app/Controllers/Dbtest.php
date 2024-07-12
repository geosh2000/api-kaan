<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\ConnectionInterface;

class Dbtest extends BaseController
{
    public function index()
    {
        // Obtenemos una instancia de la conexión 'adh_crs'
        $db = db_connect('adh_crs');

        // Realiza la consulta a la base de datos
        $query = $db->query('SELECT * FROM Agencies');

        // Obtén los resultados de la consulta como un array de objetos
        $results = $query->getResult();

        // Convertir los resultados a formato JSON
        $json = json_encode($results);

        // Establecer el tipo de contenido de la respuesta como JSON
        return $this->response->setContentType('application/json')
                               ->setBody($json);
    }

    public function conf(){
        return view('Config');
    }
}
