<?php

namespace App\Controllers\Zd;

use App\Controllers\BaseController;
use App\Libraries\Zendesk;
use Config\Globals as templates;

class Mailing extends BaseController{

    
    public function index(){
       
    }

    // SEND via Ticket
    public function sendConf( $params, $ticketData ){
        $zd = new Zendesk();
        
        // Reemplaza las variables en el HTML con valores específicos
        $html = $this->buildConfData($params['params'], $params['hotel'], $params['lang']);
        
        $ticket = [
            "title"         => "Correo de confirmacion ".($params['params']['conf_number'] ?? ""), // Concatenar con confirmacion del cliente
            "requester"     => $ticketData['requester'],  // cambiar por id de cliente
            "submitter_id"  => $ticketData['requester'],  // cambiar por id de cliente
            "public"        => true,
            "html_body"     => $html,
            "tags"          => ["confirmacion","sendMail","solveTicket"],
            "assignee_email"   => $ticketData['agentMail'],  // Cambiar por correo de agente
            "group"         => 27081970059028,  // Grupo de leisure
            "custom_fields" => [
                [
                  "id" => 26495291237524,
                  "value" => "categoria_confirmacion"
                ]
            ], 
            "followers"     => [] // array de correos
        ];
        
        $newTicket = $zd->newTicketSend($ticket);        
        
        // Envía la respuesta JSON
        gg_response(200, ["ticket_id" => $newTicket]);
    }

    // PRINT HTML
    // public function getConf( $params, $hotel, $lang = 'english' ){

    //     $params = [
    //         "data"  => [
    //             'conf_number'   =>  '392827',
    //             'main_guest'    =>  'Juan Pablo de Zulueta Razo',
    //             'date_in'       =>  '2024/05/18',
    //             'time_in'       =>  '15:00',
    //             'date_out'      =>  '2024/05/19',
    //             'time_out'      =>  '12:00',
    //             'room_code'     =>  'AXJRXK',
    //             'room_name'     =>  'Junior Suite King',
    //             'adults'        =>  2,
    //             'children'      =>  0,
    //             'payment_type'  =>  'Paga a la llegada',
    //             'currency'      =>  'MXN',
    //             'total'         =>  "11,473.50",
    //             'notes'         =>  '-',
    //             'xld_policy'    =>  '-'
    //         ],
    //         "params" => [
    //             'ROOM TYPE'     =>  false,
    //         ]
    //     ];
        
    //     // Reemplaza las variables en el HTML con valores específicos
    //     $html = $this->buildConfData($params, $hotel, $lang);

    //     echo $html;
    // }
    
    // PRINT HTML
    public function getConf(  ){

        $params = [
            "data"  => [
                "hotel"=>"hotel_atpm",
                "conf_number"   => "59829",
                "main_guest"    => "Alfonso Pérez",
                "date_in"   => "2024-07-13",
                "time_in"   => "",
                "date_out"  => "2024-07-14",
                "time_out"  => "",
                "room_code" => "",
                "room_name" => "",
                "adults"    => "2",
                "children"  => "",
                "payment_type"  => "Pago al Check-In",
                "currency"  => "mxn",
                "total" => "7024.5",
                "notes" => "",
                "xld_policy"    => "-",
                "rsv_channel"   => "rsv_chan_direct",
                "deposit"   => "",
                "rate_type" => "-",
                "isa" => "$40 MXN por persona por noche"
            ],
            "params" => [
                'ROOM TYPE'     =>  false,
                'BALANCE'       => 'hide_balance',
                'AutoXld'   => '-',
                'DEPOSITOS' => 'hide_deposit',
                "AMOUNT" => 'show_amount'
            ]
        ];
        
        // Reemplaza las variables en el HTML con valores específicos
        $html = $this->buildConfData($params, str_replace("hotel_", "", $params['data']['hotel']), $_GET['lang']);

        echo $html;
    }

    // Función para obtener el contenido HTML de un archivo remoto
    private function getRemoteHtml($url)
    {
        // Inicializa cURL
        $curl = curl_init();

        // Configura la solicitud cURL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Ejecuta la solicitud cURL y obtén el contenido HTML
        $html = curl_exec($curl);

        // Cierra la sesión cURL
        curl_close($curl);

        // Devuelve el contenido HTML
        return $html;
    }

    // Función para reemplazar variables en el HTML con valores específicos
    public function buildConfData($params, $hotel, $lang = 'english'){

        $lang = $_GET['lang'] ?? $lang;

        $fileLang = $lang == 'spanish' || $lang == 'Español (Latinoamérica)' ? 'Esp' : 'Eng';

        $params['query'] = [
            "inicio"    => $params['data']['date_in'],
            "lang"      => $fileLang
        ];

        $params['data']['date_in'] = longDateFormat($params['data']['date_in'], $fileLang);
        $params['data']['date_out'] = longDateFormat($params['data']['date_out'], $fileLang);
        $params['data']['time_in'] = isset($params['data']['time_in']) && $params['data']['time_in'] !== '' ? $params['data']['time_in'] : '15:00';
        $params['data']['time_out'] = isset($params['data']['time_out']) && $params['data']['time_out'] !== '' ? $params['data']['time_out'] : '12:00';

        // Revisa el canal
        $params['data']['rsv_channel'] = ($params['data']['rsv_channel'] ?? 'rsv_chan_direct') === 'rsv_chan_direct' ? 'ATELIERdeHoteles.com!' : 'Atelier de Hoteles';
        
        // Revisa children
        $params['data']['children'] = isset($params['data']['children']) ? ($params['data']['children'] == "" ? "0" : $params['data']['children']) : $params['data']['children'];


        // Muestra RoomType
        $params['params']['ROOM TYPE'] = isset($params['params']['ROOM TYPE']) ? ($params['params']['ROOM TYPE'] == 'show_roomtype') : true;
        
        // Muestra Depositos
        $params['params']['DEPOSITOS'] = isset($params['params']['DEPOSITOS']) ? ($params['params']['DEPOSITOS'] == 'show_deposit') : false;
        if( $params['params']['DEPOSITOS'] ){
            $params['params']['DEP ATPM'] = $hotel == 'atpm';
            $params['params']['DEP OLCP'] = $hotel == 'olcp';
        }


        // Muestra Amount
        $params['params']['AMOUNT'] = isset($params['params']['AMOUNT']) ? ($params['params']['AMOUNT'] == 'show_amount') : true;
        
        // Muestra Niños
        // $params['data']['children'] = isset($params['params']['AMOUNT']) ? ($params['params']['AMOUNT'] == 'show_amount') : true;

        // Muestra Balance
        $params['params']['BALANCE'] = isset($params['params']['BALANCE']) ? ($params['params']['BALANCE'] == 'show_balance') : false;
        if( $params['params']['BALANCE'] ){
            $params['data']['balance'] = moneyFormat(bcsub($params['data']['total'], $params['data']['deposit'] ?? 0, 2));
            $params['data']['deposit'] = moneyFormat($params['data']['deposit'] ?? 0);
        }
        $params['data']['total'] = moneyFormat($params['data']['total']);


        // Datos de hotel
        switch( strtolower($hotel) ){
            case 'atpm':
                $html_url = $fileLang;
                $params['data']['hotel_name'] = "Atelier Playa Mujeres";
                $params['data']['logo_url'] = "https://glassboardengine.azurewebsites.net//assets/img/logo.png";
                $params['data']['dir_1'] = "Complejo de Condominios Playa Mujeres, SM-3 M-1 L-13 RTH-4";
                $params['data']['dir_2'] = "Zona Continental Isla Mujeres,    ";
                $params['data']['dir_3'] = "Quintana Roo, México, C.P. 77400  ";
                $params['data']['dir_4'] = "+52 (998) 500 4800";
                $params['query']['hotel'] = 1;
                break;
            case 'olcp':
                $html_url = $fileLang;
                $params['data']['hotel_name'] = "Oleo Cancún Playa";
                $params['data']['logo_url'] = "https://glassboardengine.azurewebsites.net//assets/img/logoOleo.png";
                $params['data']['dir_1'] = "Boulevard Kukulcán KM 19.5, Zona Hotelera,";
                $params['data']['dir_2'] = "Cancún, Mexico, 77500.";
                $params['data']['dir_3'] = "";
                $params['data']['dir_4'] = "+52 (998) 313 0126";
                $params['query']['hotel'] = 5;
                break;

        }

        // Calcular XLD Policy
        if( $params['params']['AutoXld'] == 'policy_auto' ){
            $params['data']['xld_policy'] = $this->getPenalties($params['query']);
        }

        // Obtiene el contenido HTML del archivo remoto
        $html = $this->getRemoteHtml(templates::$templates.'mailConf'.$html_url.'.html');

        // Desactiva bloques false
        foreach($params['params'] as $bloque => $b){
            if (!$b) {
                // Buscar y eliminar el contenido entre <!-- START --> y <!-- END -->
                $regex = "/<!-- $bloque START -->.*?<!-- $bloque END -->/s";
                $html = preg_replace($regex, '', $html);
            }
        }
        
        // Reemplaza cada variable en el HTML con su valor correspondiente
        foreach ($params['data'] as $variable => $value) {
            $html = str_replace('${' . $variable . '}', $value, $html);
        }

        return $html;
    }

    protected function getPenalties( $filter ){
        $db = \Config\Database::connect('production');

        $builder = $db->table('policies_xld');

        $result = $builder->where("'".$filter['inicio']."' BETWEEN start AND end")
            ->where("hotel", $filter['hotel'])
            ->get();

        $penalty = $result->getResult('array')[0];


        // Crea un objeto DateTime a partir de la fecha de inicio
        $inicioDate = new \DateTime($filter['inicio']);

        // Resta x días a la fecha de inicio
        $interval = new \DateInterval('P' . ($penalty['days_prior'] + 1) . 'D');
        $inicioDate->sub($interval);

        // Asigna la nueva fecha a la variable limit
        $limit =  longDateFormat($inicioDate->format('Y-m-d'), $filter['lang']);

        $text = [
            "Esp" => "Cancelación gratuita hasta el $limit. Después de esta fecha, se aplica una penalidad del ".($penalty['penalty'] * 100)."%.",
            "Eng" => "Free cancellation until $limit. Between 0 and 14 days before arrival, a ".($penalty['penalty'] * 100)."% penalty applies."
        ];

        return $text[$filter['lang']];

    }
}
