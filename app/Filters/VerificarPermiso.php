<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class VerificarPermiso implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si se ha proporcionado un permiso en los argumentos
        if (empty($arguments)) {
            return $this->responseError('No se ha especificado un permiso para esta ruta.');
        }

        // Obtener el permiso requerido de los argumentos
        $permiso = $arguments[0];

        // Obtener los permisos guardados en la sesión
        $permisosSesion = session('permisos');

        // Verificar si el usuario tiene el permiso requerido en la sesión
        if (!$this->tienePermiso($permisosSesion, $permiso)) {
            return $this->responseError('No tiene permiso para acceder a esta página.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario implementar este método en este filtro
    }

    private function tienePermiso($permisosSesion, $permiso)
    {
        // Verificar si el permiso requerido está en la lista de permisos del usuario en la sesión
        return in_array($permiso, $permisosSesion);
    }

    private function responseError($message)
    {
        return service('response')->setStatusCode(403)->setJSON(['error' => $message]);
    }
}
