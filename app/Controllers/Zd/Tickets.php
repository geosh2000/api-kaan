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
    
    public function metrics( $ticket_id = 3091 ){
        
       
        $result = $this->zd->getData( "api/v2/tickets/".$ticket_id."/metrics" );

        if( $result["response"] != 200 ){
            gg_response(400, $result['data']);
        }

        if($result['response'] == 200 ){
            $metrics = json_decode(json_encode($result['data']->ticket_metric),true);

            $resume = [];

            $lastIsRequester = $metrics['assignee_updated_at'] < $metrics['requester_updated_at'];

            $resume = [
                'lastIsRequester' => $lastIsRequester,
                'minutesSinceLastRequester' => $lastIsRequester ? minutesSince($metrics['requester_updated_at']) : 0
            ];

            gg_response($result['response'], [ "metrics" => $resume, "data" => $metrics ]);
        }

        gg_response($result['response'], [ "data" => $result ]);
        
    }

    public function whatsVipSlaJob(){

        $tags = "via:whatsapp status<solved tags:whatsapp_vip";
        $encoded_tags = urlencode($tags);

        // Busca tickets de Whatsapp VIP sin notificacion
        $result = $this->zd->getData( "api/v2/search.json?query=$encoded_tags");

        if( $result['response'] != 200 ){
            gg_response(400, ['data' => $result]);
        }
        
        $tickets = json_decode(json_encode($result['data']->results),true);

        $wvt = [];
        $notified = [];

        // Define el arreglo de conversaciones VIP activas
        foreach($tickets as $tkt => $t){
            if( in_array("sla_breach_notified_vip", $t['tags']) ){
                array_push($notified,$t['id']);
            }else{
                array_push($wvt,$t['id']);
            }
        }

        // Busca los eventos desde medianoche 
        date_default_timezone_set('UTC');
        $time = strtotime("today midnight");
        $result = $this->zd->getData( "api/v2/incremental/ticket_metric_events?start_time=$time" );
        $data = json_decode(json_encode($result['data']->ticket_metric_events),true);

        // Filtra solo eventos con SLA
        $events = [];
        foreach($data as $event => $e){
            
            $flag = in_array([$e['metric'], $e['type']], [
                ['reply_time', 'breach'],
                ['reply_time', 'apply_sla'],
                ['reply_time', 'update_status'],
            ]);

            if( $flag ){
                if( isset($events[$e['ticket_id']]) ){
                    $events[$e['ticket_id']][$e['type']] = $e;

                }else{
                    $tmp = [$e['type'] => $e];
                    $events[$e['ticket_id']] = $tmp;
                }
            }
        }

        $updateTag = [];
        $removeTag = [];

        // Filtra solo eventos de tickets activos sin notificaciones
        foreach( $events as $ticket => $t){
            // if( in_array($ticket, $wvt) && isset($t['apply_sla']) && isset($t['apply_sla']['sla']['policy']['id']) ){
            if( isset($t['apply_sla']) && isset($t['apply_sla']['sla']['policy']['id']) ){
                $slaId = $t['apply_sla']['sla']['policy']['id'];

                if( $slaId != 29502917136276 ){
                    unset($events[$ticket]);
                    continue;
                }

                $events[$ticket]['stillBreach'] = false;
                if( isset($t['breach']) && isset($t['apply_sla']) ){
                    if( !isset($t['update_status']) ){
                        $events[$ticket]['stillBreach'] = true;
                    }else{
                        if( $t['breach'] > $t['update_status'] ){
                            $events[$ticket]['stillBreach'] = true;
                        }
                    }
                    
                }

                if( !$events[$ticket]['stillBreach'] ){
                    if( in_array($ticket, $notified) ){
                        array_push($removeTag, $ticket);
                    }
                    unset($events[$ticket]);
                }else{
                    if( in_array($ticket, $wvt) ){
                        array_push($updateTag, $ticket);
                    }
                }

            }else{
                unset($events[$ticket]);
            }
        }

        if( count($updateTag) > 0 ){
            $tids = implode(",",$updateTag);
            $result = $this->zd->putData( "https://atelierdehoteles.zendesk.com/api/v2/tickets/update_many.json?ids=$tids", ["ticket" => ["additional_tags" => ["send_sla_breach_notification"]]] );
        }
        if( count($removeTag) > 0 ){
            $tids = implode(",",$removeTag);
            $result = $this->zd->putData( "https://atelierdehoteles.zendesk.com/api/v2/tickets/update_many.json?ids=$tids", ["ticket" => ["remove_tags" => ["sla_breach_notified_vip"]]] );
        }
    
        gg_response($result['response'], [ "events" => $events ]);
    }

    public function searchQuery( $query ){
        $result = $this->zd->getData( "api/v2/search.json?query=".$query );
        
    
        gg_response($result['response'], [ "data" => $result ]);
    }

    public function audits( $ticket_id ){

        $result = $this->zd->getData( "/api/v2/tickets/$ticket_id/audits" );

        $data = json_decode(json_encode($result['data']),true);

        $res = [];

        foreach( $data['audits'][0]['events'] as $audit => $event ){
            array_push($res, $event['type']);
        }
  
        // echo $comment;
        gg_response(200, [ "types" => $res, "data" => $data['audits']]); 
    }

    public function whatsConv( $ticket ){
        $result = $this->zd->ss_getMessages($ticket, false);
  
        gg_response(200, $result); 
    }
    
    public function sendMsgToConv( $ticket ){

        $content = [
            "type" => $_POST['type'] ?? "carousel",
            // "text" => $_POST['message'] ?? "Prueba de botones",
            "items" => [
                [ 
                    "title" => "Junior Suite - 2 Double", 
                    "description" => truncateText("Luxury suite with work desk and a single sofa bed. This suite has a balcony overlooking the golf course or with a jungle view subject to availability.", 128), 
                    "mediaUrl" => "https://ateliercdn.azureedge.net/bookingengine/atpm/AXJRXQ/AXJRXQ_1.jpg",
                    "mediaType" => "image/jpeg",
                    "size" => "compact",
                    "actions" => [
                        [ "type" => "postback", "text" => "Elegir Habitación", "payload" => "select" ],
                        [ "type" => "postback", "text" => "Más detalles", "payload" => "question" ]
                    ],
                    "metadata" => ["category" => "AXJRXQ"]
                ],
                [ 
                    "title" => "Junior Suite - King", 
                    "description" => truncateText("Luxury suite with work desk and a single sofa bed. This suite has a balcony overlooking the golf course or with a jungle view subject to availability.", 128), 
                    "mediaUrl" => "https://ateliercdn.azureedge.net/bookingengine/atpm/AXJRXK/AXJRXK_1.jpg",
                    "mediaType" => "image/jpeg",
                    "size" => "compact",
                    "actions" => [
                        [ "type" => "postback", "text" => "Elegir Habitación", "payload" => "select" ],
                        [ "type" => "postback", "text" => "Más detalles", "payload" => "question" ]
                    ],
                    "metadata" => ["category" => "AXJRXK"]
                ]
            ],
        ];

        $result = $this->zd->ss_sendMessage($ticket, $content);
  
        gg_response(200, $result); 
    }

    public function notifyWhats(){
        
        $dest = "529982140469";
        $text = "Esta es una notificación de prueba";
        
        $result = $this->zd->ss_sendNotification( $dest, $text );

        gg_response(200, ['data' => $result]);
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

    public function getPublicKey()
    {
        $appId = 1057090;
        $result = $this->zd->getData( "/api/v2/apps/$appId/public_key.pem", true);
        
        echo $result['data'];
    }
    
    public function installations()
    {
        $appId = 1054506;
        $result = $this->zd->getData( "/api/v2/apps/installations.json");
        
        gg_response($result['response'], $result['data']);
    }
    
    public function appAud()
    {
        $appInsId = 28666254387092;
        $result = $this->zd->getData( "/api/v2/apps/installations/$appInsId.json");
        
        gg_response($result['response'], $result['data']);
    }

    public function testUpdate(){

        $dataTicket = [
            "status" => "open",
            "custom_status_id" => 25706430890260
        ];

        $result = $this->zd->updateTicket(160722, $dataTicket);

        gg_response(200, ['data' => $result]);
    }

    public function fromContactForm(){

        $postData = getPost();

        $name = $postData['name'];
        $mail = $postData['mail'];
        $msg = $postData['msg'];

        switch( $postData['hotel'] ){
            case "Atelier Playa Mujeres":
                $hotel = 'hotel_atpm';
                break;
            case "Oleo Cancun Playa":
                $hotel = 'hotel_olcp';
                break;
        }

        $params = [
                "ticket" => [
                    "subject" => "ATELIER DE HOTELES Site - Contacto Web", 
                    "comment" => [
                        "body" => $msg
                    ], 
                    "requester" => [
                        "name" => $name, 
                        "email" => $mail,
                    ],
                    "custom_fields" => [
                        ["id" => 26493544435220, "value" => $hotel],
                    ] 
                    
                   ] 
             ]; 

        if( isset($postData['phone']) ){
            $params['ticket']['requester']['phone'] = $postData['phone'];
        } 

        $result = $this->zd->onBehalfTicket( $params );
        gg_response(200, ['name' => $result]);
    }
    


}
