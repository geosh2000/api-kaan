<?php

namespace App\Controllers\Zd;

use App\Controllers\BaseController;
use App\Controllers\Zd\Objects;
use App\Libraries\Zendesk;

class Users extends BaseController{

    protected $zd;
    protected $custom_fields;

    public function __construct(){
        $this->zd = new Zendesk();

        $this->custom_fields = [
            "bloqueo" => 26270545805588
        ];
    }

    
    public function index(){
        
    }


    public function showUser( $id ){
        $result = $this->zd->getUser( $id );

        gg_response( $result['response'], $result );
    }

    public function webhook(){
        
        // Obtener la instancia del servicio request
        $request = \Config\Services::request();
        $data = json_decode(json_encode($request->getVar()),true);; // Decodificar el JSON en un array asociativo

        // Verificar si el método existe en el controlador
        if (method_exists($this, $data['metodo'])) {
            // Llamar al método dinámicamente
            call_user_func_array(array($this, $data['metodo']), array($data['params']));
        } else {
            // Manejar el caso en el que el método no existe
            gg_response(400, ["msg" => "El método especificado no existe en este controlador"]);
        }
    }

}
