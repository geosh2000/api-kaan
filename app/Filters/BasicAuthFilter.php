<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\JWT\Key as jkey;
use App\Libraries\JWT\JWT;
use App\Models\Logs\TokenModel;
use Config\Globals as JWTConfig;

date_default_timezone_set('America/Cancun');

class BasicAuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        // Establecer la zona horaria de la base de datos
        $db = db_connect('production');
        $db->query("SET time_zone = '-05:00';"); // Ajusta esto según la zona horaria deseada

        // Verificar si se ha proporcionado un token
        $token = $request->getHeaderLine('Authorization');

        if (!$token) {
            return redirect()->to(site_url('login').'?'.$_SERVER['QUERY_STRING'])
                ->with('error', 'Sesión expirada o no existente');
            // return service('response')->setStatusCode(401)->setJSON(['message' => 'Token no proporcionado']);
        }

        // Eliminar el prefijo "Bearer " del token
        $token = str_replace('Bearer ', '', $token);

        // Decodificar el token JWT
        try {
            $key = JWTConfig::$jwtKey;
            $JK = new jkey($key, 'HS256');
            $decoded = JWT::decode($token, $JK);
        } catch (\Exception $e) {
            return service('response')->setStatusCode(401)->setJSON(['message' => 'Token inválido key']);
        }

        // Verificar si el token existe y está activo en la base de datos
        $tokenModel = new TokenModel();
        $tokenRecord = $tokenModel->where('token', $token)->first();

        if (!$tokenRecord ) {
            // Si el token no existe, no está activo, ha expirado o no se ha utilizado en la última hora, lo marcamos como inválido
            if ($tokenRecord) {
                $tokenModel->delete($tokenRecord['id']);
            }
            return service('response')->setStatusCode(401)->setJSON(['message' => 'Token inválido mysq' ]);
        }

        if (!$tokenRecord || strtotime($tokenRecord['updated_at']) < (time() - 3600) || $decoded->exp < time()) {
            // Si el token no existe, no está activo, ha expirado o no se ha utilizado en la última hora, lo marcamos como inválido
            if ($tokenRecord) {
                $tokenModel->delete($tokenRecord['id']);
            }
            return service('response')->setStatusCode(401)->setJSON(['message' => 'Token inválido time', 'token' => $tokenRecord, 'decoded' => $decoded, 'time' => time()]);
        }

        // Si el token es válido, activo y se ha utilizado en la última hora, actualizamos updated_at
        $tokenModel->update($tokenRecord['id'], ['updated_at' => date('Y-m-d H:i:s')]);

        // Pasamos la solicitud
        return $request;
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario implementar este método en este filtro
    }
}