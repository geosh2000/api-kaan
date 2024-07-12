<?php

namespace App\Controllers\Zd;

use App\Controllers\BaseController;
use App\Controllers\Zd\Objects;
use App\Libraries\Zendesk;
use App\Libraries\Adh\AdhApi;
use App\Controllers\Zd\Mailing;

class Tickets extends BaseController{

    protected $zd;
    protected $custom_fields;

    public function __construct(){
        $this->zd = new Zendesk();

        $this->custom_fields = [
            "bloqueo" => 26270545805588
        ];
    }

    
    public function index( $ticket_id = 3091 ){
        
       
        $result = $this->zd->getData( "api/v2/tickets/".$ticket_id );

        if( $result["response"] != 200 ){
            gg_response(400, $result['data']);
        }

        $bloqueo = [];
        $bloqueo = $this->getBloqueo( $result['data']->ticket );

        if( $bloqueo ){
            $obj = new Objects();
            $deadline = $obj->getRlDeadline( $bloqueo );
        }

        gg_response(200, [ "ticket" => $result['data']->ticket, "bloqueo" => $bloqueo, "deadline" => $deadline ?? null ]);
        
    }

    public function audits( $ticket_id ){

        $result = $this->zd->getData( "/api/v2/incremental/tickets/$ticket_id/emails.json?resource=20614455/203aee2d-6b04-49d1-b307-f6536c63f04f.json" );
        gg_response($result['response'], [ "data" => $result]); 
        // $result = $this->zd->getData( "/api/v2/tickets/$ticket_id/audits/26669641271060" );

        // $result['data'] = json_decode(json_encode($result['data']),true);

        // $result['json']=$result['data']['audit']['metadata']['system'];

        // $json = $result['json']['json_email_identifier'];
        // $uri  = "/api/v2/incremental/tickets/cursor.json?resource=".$json;

        // $mail  = $this->zd->getData( $uri );

        // gg_response($result['response'], [ "json" => $mail, "data" => $result['data']]); 


        $result = $this->zd->getData( "/api/v2/tickets/$ticket_id/audits" );

        $data = json_decode(json_encode($result['data']),true);

        $comment = "";

        foreach( $data['audits'][0]['events'] as $audit => $event ){
            if( $event["type"] == 'Comment' ){
                $comment = $event['html_body'];
            }
        }
  
        // echo $comment;
        gg_response($result['response'], [ "data" => $data['audits']]); 
    }

    public function adhFormToClient( $data ){
        
        $ticket = $data['ticket'] ?? false;
        
        $result = $this->zd->getData( "api/v2/tickets/".$ticket );

        $result['data'] = json_decode(json_encode($result['data']),true);

        $texto = $result['data']['ticket']['description'];

        // Patrones de expresiones regulares para extraer el nombre y el correo electrónico
        $patron_nombre = '/Name: (.*)\n/';
        $patron_email = '/Email: (.*)\n/';

        // Variables para almacenar el nombre y el correo electrónico
        $nombre = '';
        $email = '';

        // Buscar coincidencias utilizando expresiones regulares
        if (preg_match($patron_nombre, $texto, $coincidencias_nombre)) {
            $nombre = $coincidencias_nombre[1];
        }

        if (preg_match($patron_email, $texto, $coincidencias_email)) {
            $email = $coincidencias_email[1];
        }

        // Buscar Usuario
        $userSearch = $this->zd->searchUserByMail($email);
        if( strpos($userSearch['response'], '2') === 0 ){
            $userSearch['data'] = json_decode(json_encode($userSearch['data']),true);
            // gg_response(200, [$userSearch, $email]);
            if( $userSearch['data']['count'] > 0){
                $userId = $userSearch['data']['users'][0]['id'];
            }else{
                $newUser = $this->zd->crearUsuario($nombre, $email);
                if( strpos($newUser['response'], '2') === 0 ){
                    $newUser['data'] = json_decode(json_encode($newUser['data']),true);
                    $userId = $newUser['data']['user']['id'];
                }else{
                    gg_response(400, ["error" => $newUser] );
                }
            }

            $data = ["requester_id" => $userId];
            $update = $this->zd->updateTicket($ticket, $data);
            if( strpos($update['response'], '2') === 0 ){
                $update['data'] = json_decode(json_encode($update['data']),true);
                
                gg_response($update['response'], [ "data" => $update['data']]); 
            }else{
                gg_response($update['response'], ["error" => "Error al crear usuario"] );
            }
        }else{
            gg_response($userSearch['response'], ["error" => "Error al crear usuario"] );
        }

        

    }


    public function showFields(){
        $result = $this->zd->getData( "api/v2/ticket_fields" );
        gg_response(200, $result);
    }

    public function getBloqueo( $data ){
        foreach( $data->custom_fields as $f => $field ){
            if( $field->id == $this->custom_fields['bloqueo'] ){
                $bloqueo_id = $field->value ?? false;
                return $bloqueo_id;
            }
        }
    }

    public function closeTicket( $ticket ){
        $result = $this->zd->closeTicket( $ticket );

        gg_response($result['response'], ['data' => $result['data']] );
    }

    public function addTag( $data ){

        $type = $data['type'] ?? false;
        $id = $data['id'] ?? false;
        $tag = $data['tag'] ?? false;

        if( !$id || !$type || !$tag ){ gg_response(400, ['msg' => 'Información incompleta en payload']); }

        $result = $this->zd->addTags($type, $id, $tag);

        gg_response($result['response'], ['data' => $result['data']] );
    }

    public function updateTicket( $data ){

        $ticket = $data['ticket'] ?? false;
        $data = $data['data'] ?? false;

        if( !$ticket || !$data ){ gg_response(400, ['msg' => 'Información incompleta en payload']); }

        $result = $this->zd->updateTicket($ticket, $data);

        gg_response($result['response'], ['data' => $result['data']] );

    }

    public function answerConf( $data ){

        $zd = new Mailing();

        $ticket = $data['ticket'] ?? false;
        $data = $data['data'] ?? false;

        if( !$ticket || !$data ){ gg_response(400, ['msg' => 'Información incompleta en payload']); }

        $html = $zd->buildConfData($data['params'], str_replace("hotel_", "", $data['hotel']), $data['lang']);

        $dataTicket = [
            "comment"   =>  [
                "public"        => true,
                "html_body"     => $html,
            ]
        ];

        $result = $this->zd->updateTicket($ticket, $dataTicket);

        gg_response($result['response'], ['data' => $result['data']] );

    }

    public function updateManyTickets( $data ){

        $ticket = $data['ticket'] ?? false;
        $data = $data['data'] ?? false;

        if( !$ticket || !$data ){ gg_response(400, ['msg' => 'Información incompleta en payload']); }

        $result = $this->zd->updateManyTickets($ticket, $data);

        gg_response($result['response'], ['data' => $result['data']] );

    }

    public function queueTag( $data ){

        $ticket = $data['ticket'] ?? false;
        $data = $data['tags'] ?? false;

        if( !$ticket || !$data ){ gg_response(400, ['msg' => 'Información incompleta en payload']); }

        
        $result = $this->zd->getTicket( $ticket );

        if( strpos($result['response'], '2') === 0 ){
            $ticket_data = json_decode(json_encode($result['data']->ticket),true);
            $tags = $ticket_data['tags'];
            $tags = array_filter($tags, function($elemento) {
                return strpos($elemento, "queue_") !== 0; // Verificar si el elemento no comienza con "queue_"
            });

            array_push($tags, "queue_activate");
            array_push($tags, str_replace(" ", "_", $data));

            $this->updateTicket( ["ticket" => $ticket, "data" => ["tags" => $tags]] );
        }



        gg_response($result['response'], ['data' => $result['data']] );

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

    public function getReservation( $rsva ){
        $adh = new AdhApi();

        $result = $adh->getFromF2go($rsva);

        gg_response($result['response'], $result['data']);
    }

}
