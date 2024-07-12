<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\JWT\JWT;

class AuthController extends BaseController
{
    private $zendeskSubdomain = 'atelierdehoteles';
    private $sharedSecret = 'your_shared_secret';

    public function login()
    {
        // Tu lógica de autenticación aquí
        // Supongamos que has autenticado al usuario y tienes su información en $user

        $user = [
            'id' => 123, // ID del usuario en tu sistema
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];

        // Generar el token JWT
        $token = [
            'jti' => md5(uniqid()), // ID único para la solicitud
            'iat' => time(), // Hora actual en segundos desde el Unix Epoch
            'email' => $user['email'], // Email del usuario
            'name' => $user['name'], // Nombre del usuario
            'external_id' => $user['id'] // ID del usuario en tu sistema
        ];

        $jwt = JWT::encode($token, $this->sharedSecret);

        // Redirigir al usuario a Zendesk con el token JWT
        $redirectUrl = "https://{$this->zendeskSubdomain}.zendesk.com/access/jwt?jwt=$jwt";
        return redirect()->to($redirectUrl);
    }

    public function logout()
    {
        // Lógica para cerrar sesión en tu sistema
        session()->destroy();
        return redirect()->to('/');
    }
}
