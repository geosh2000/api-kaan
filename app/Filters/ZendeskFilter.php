<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use CodeIgniter\I18n\Time;
use App\Libraries\fbjwt\JWT;
use App\Libraries\fbjwt\KEY;

class ZendeskFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper(['common']);
        // Verifica si la solicitud es POST y si el token está presente
        $token = $_POST['token'] ?? null;
        if (!$token) {
            // Si el token no está presente, devuelve un error
            return redirect()->to('/error')->with('error', 'Missing token. Sorry, no can do.');
        }

        
        
        
        // Obtén la clave pública desde el entorno o configuración
        $audience = "https://atelierdehoteles.zendesk.com/api/v2/apps/installations/28666254387092.json";
        $key = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxDGfD2iTUCLItoHoKHTQ
TBzxWpQrLZYBkgkkGqgrmex8BFnWawYok+LyivQJleW9asInb8PMpR9lVdjX+6cd
nU7lJtB/w2tImSNjaE10cd+QksvLkY8tcV1IRT34W7hkqvMeyudQ/mvHhIrflT5/
3RxXLbUr4ddsFBP9/MdrsvbsKq6VmT0BS20/fqpvMIAWBA31us91bFqCk3yetX3v
tbQVYcIkECS4gwEcL3xYAqAhWftfUZHUDQ27S5UsYucs9OxAwcnQFJrJWy7c+Oua
yyEshKfLbMuegMDli7C79/AXkHe3nbRak7RAz95N4pVspqS5vA3T7cx1g4X5cc4T
EwIDAQAB
-----END PUBLIC KEY-----";
        // echo $key;
        // return;
        
        try {
            // Decodifica el token
            $decoded = JWT::decode($token, new Key($key, 'RS256'));
            $response = Services::response();
            $response->setCookie('zdapp', 'valid', 72000); // La cookie dura 1 hora
            
            // Verifica la audiencia
            if ($decoded->aud !== $audience) {
                gg_response(400, 'Invalid audience.');
            }
            
        } 
        catch (\Exception $e) {
            gg_response(400, '401 Invalid token. Calling the cops.');
        }

        
        
        // Continúa con la solicitud
        return null;
    }
    
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Establece la cookie con los parámetros de la consulta
        $qs = $request->getUri()->getQuery(); // Usa getUri()->getQuery() para obtener la cadena de consulta
        $response->setCookie('my_app_params', $qs);
    }
}

