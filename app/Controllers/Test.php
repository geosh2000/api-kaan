<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\JWT\JWT;

// Carga el helper common
helper(['common']);

class Test extends BaseController
{
    public function index()
    {
        // Devuelve un mensaje de éxito
        gg_response(200, ['error' => false, 'msg' => 'Hola mundo']);
    }

    public function dbs()
    {
        // Obtener el parametro de db desde post, si este no existiera, se asigna el valor 'default'
        $db_post = $this->request->getPost('db') ?? 'default';

        // Obtener la conexión a la base de datos
        $db = db_connect($db_post);

        // Si la conexión es fallida, devolver error "Base de datos incorrecta"
        if (!$db) {
            return $this->response->setJSON(['error' => true, 'msg' => 'Base de datos incorrecta']);
        }

        // Si la conexion es 'default' devolver un conteo de usuarios de la base "Users"
        if ($db_post === 'default') {
            $users = $db->table('Users')->countAllResults();
            return $this->response->setJSON(['users' => $users]);
        }else{
            // Si la conexion es 'adh_crs' devolver un conteo de usuarios de la base "Reservations"
            $reservations = $db->table('Reservations')->countAllResults();
            return $this->response->setJSON(['reservations' => $reservations]);
        }

    }

    public function jwt()
    {
        // Generar un token de prueba
        $key = 'tu_clave_secreta';
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora

        $payload = [
            'username' => 'usuario_prueba',
            'iat' => $issuedAt,
            'exp' => $expirationTime
        ];

        $token = JWT::encode($payload, $key);

        // Devolver el token en la respuesta
        return $this->response->setJSON(['token' => $token]);
    }
}
