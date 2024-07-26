<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class ZdCookieFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cookies = Services::response();
        $cookie = $cookies->getCookie('zdapp');
        
        if ($cookie !== 'valid') {
            return redirect()->to('/error')->with('error', 'Unauthorized access. Please log in first.');
        }
        
        return null;
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita ninguna acción aquí
    }
}
