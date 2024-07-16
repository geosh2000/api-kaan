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

        $session = session();

        // Obtener los datos de usuario y contraseña del request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password') ?? '';

        // Validar las credenciales del usuario
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            $pass = $user['password'];
            $authenticatePassword = password_verify($password, $pass);

            if ($authenticatePassword) {
                $sessionData = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'logged_in' => TRUE
                ];
                $session->set($sessionData);

                // Redirigir a la URL de origen o a '/adh'
                $redirect_url = $session->get('redirect_url') ?? '/adh';
                $session->remove('redirect_url');
                return redirect()->to($redirect_url);
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to(site_url('login'));
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to(site_url('login'));
        }

    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function resetPassword()
    {
        // Lógica para resetear la contraseña
    }

    public function showLogin(){
        return view('Login/login');
    }
}

