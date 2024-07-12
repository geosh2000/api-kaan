<?php

namespace App\Controllers\Log;

use App\Controllers\BaseController;
use App\Libraries\JWT\JWT;
use App\Models\Usuarios\UserModel;
use App\Models\Logs\TokenModel;
use Config\Globals as JWTConfig;
use App\Models\Usuarios\RolesPermisosModel;

class Login extends BaseController
{
    public function login(){

        // Obtener los datos de usuario y contraseña del request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validar las credenciales del usuario
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON(['message' => 'Credenciales inválidas']);
        }

        // Generar el token JWT
        $key = JWTConfig::$jwtKey;
        $issuedAt = time();
        $expirationTime = $issuedAt + (8 * 3600); // Token válido por 8 horas

        $payload = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'iat' => $issuedAt,
            'exp' => $expirationTime
        ];

        $token = JWT::encode($payload, $key);

        // Guardar la información del token en la tabla 'tokens'
        $tokenModel = new TokenModel();
        $tokenModel->insert([
            'user_id' => $user['id'],
            'token' => $token,
            'expiration_date' => date('Y-m-d H:i:s', $expirationTime)
        ]);

        // Obtener los roles del usuario desde la base de datos
        $rolesPermisosModel = new RolesPermisosModel();
        $permisos = $rolesPermisosModel->obtenerPermisosPorUsuario($user['id']);

        // Guardar los permisos en la sesión
        session()->set('permisos', $permisos);

        // Devolver el token en la respuesta
        return $this->response->setJSON(['token' => $token]);
    }

    public function showLogin(){
        return view('Login/login');
    }
}

