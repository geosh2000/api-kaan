<?php namespace App\Libraries;

class Zendesk{
    
    protected $i;
    protected $username = 'contact@adh.com';
    protected $password = '2UoCtx1qHT0qIfNvc849wSGFE3MP9ddVWfuAi6zm';
    protected $baseUrl = "https://atelierdehoteles.zendesk.com";
    protected $baseUser = 26417292260372; // Atelier de Hoteles
    protected $baseGroup = 27081970059028; // Leisure
    protected $oAuth = "746907e0b3387a138d2dd5a19e6866bc38ad1c2d7311ed329bc740688cae16a1";
    protected $oAuthOk = "f3e073622652f4fedc8425642410bb38457734751a4bf63cd047815a0ffff5e6";

    
    function __construct() {

    }
    
    protected function putData( $url, $arr = null ){
        
        $ch = curl_init();
        
        if( is_array($arr) ){
            $arr = json_encode($arr);
        }
        
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->username . '/token:' . $this->password );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $arr);
        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );

        $data = curl_exec( $ch );
        $status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        
        curl_close( $ch );
        
        return array( 'response' => $status, 'data' => json_decode($data) );
    }
    
    public function postData( $url, $arr ){
        
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->username . '/token:' . $this->password );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $arr);
        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
        
        $data = curl_exec( $ch );
        $status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        
        curl_close( $ch );
        
        return array( 'response' => $status, 'data' => json_decode($data) );
    }
    
    public function getData( $url, $noJson = false ){
        
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_URL, $this->baseUrl."/$url" );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->username . '/token:' . $this->password );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));     
        
        $data = curl_exec( $ch );
        $status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        
        curl_close( $ch );
        
        return array( 'response' => $status, 'data' => $noJson ? $data : json_decode($data) );
    }
    
    public function getDataO( $url ){
        
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_URL, $this->baseUrl."/$url" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->oAuthOk
        ]);   
        
        $data = curl_exec( $ch );
        $status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            array( 'response' => 500, 'error' => $error_msg );
        }
        
        curl_close( $ch );
        
        return array( 'response' => $status, 'data' => json_decode($data) );
    }

    public function getAudits($ticket){
        $result = $this->getData( "api/v2/tickets/".$ticket );
        return $result;
    }

    public function updateTicket( $ticket, $data ){
        $params = ["ticket" => $data];
        return $this->putData( $this->baseUrl."/api/v2/tickets/".$ticket, $params );
    }

    public function updateManyTickets( $tickets, $data ){
        $params = ["ticket" => $data];
        $ticket = implode(",", $tickets);
        return $this->putData( $this->baseUrl."/api/v2/tickets/update_many.json?ids=".$ticket, $params );
    }

    public function addTags( $type, $id, $tags ){

        // Array con los valores permitidos
        $valoresPermitidos = ['ticket', 'organizacion', 'usuario'];

        // Verificar si el valor pasado está en la lista de valores permitidos
        if (!in_array($type, $valoresPermitidos)) {
            throw new \InvalidArgumentException('El valor de $tipo no es válido.');
        }

        // Valida si $tags es arreglo
        $tags = is_array($tags) ? $tags : [$tags];

        // Establece la URI correcta de acuerdo al tipo
        switch($type){
            case "ticket":
                $uri = "/api/v2/tickets/$id/tags";
                break;
            case "organizacion":
                $uri = "/api/v2/organizations/$id/tags";
                break;
            case "usuario":
                $uri = "/api/v2/users/$id/tags";
                break;
        }

        $url = $this->baseUrl.$uri;

        $params = [
            "tags" => $tags,
            // "updated_stamp" => date('Y-m-d\TH:i:s\Z'),
            // "safe_update" => "true"
        ];

        return $this->putData( $url, $params );
    }

    public function closeTicket( $ticket ){
        $params = ["ticket" => [ "status" => "closed" ]];
        return $this->putData( $this->baseUrl."/api/v2/tickets/".$ticket, $params );
    }
    
    // public function saveHistory( $id, $msg, $notify = null, $noMl = false, $arrWhere = null ){
        
    //     // $id es el ticket del hisorial
    //     // si no se tiene el ticket, se puede pasar un arreglo con dos elementos
    //     //   --> Elemento 0 => valor de busqueda
    //     //   --> Elemento 1 => campo de busqueda
        
    //     if( $noMl ){
    //         $mlq = $this->i->db->select('historyTicket')->from('cycoasis_rsv.r_masterlocators a')->join('cycoasis_rsv.r_items b', 'a.masterlocatorid = b.masterlocatorid', 'left')->where($arrWhere)->get();
    //         $mlr = $mlq->row_array();
    //         $id = $mlr['historyTicket'];
    //     }
        
    //     // si id es arreglo, busca el ticket del historial a traves del modelo RSV
    //     if( is_array($id) ){
    //         $this->i->load->model('Rsv_model');
    //         $rsv = new Rsv_model;
            
    //         $arr = $id;
            
    //         // si el campo de busqueda es distinto a itemid, obtiene primero el itemid desde el modelo RSV
    //         if( strtolower($arr[1]) != 'itemid' ){
                
    //             $itemIdQ = $rsv->getId( $arr[0], $arr[1] );
                
    //             if( !$itemIdQ['err'] ){
    //                 $itemId = $itemIdQ['data'];
    //             }else{
    //                 return false;
    //             }
    //         }else{
    //             $itemId = $arr[0];
    //         }
            
    //         $idq = $rsv->getHistoryTicket($itemId);
            
    //         if( !$idq['err'] ){
    //             $id = $idq['data'];
    //         }else{
    //             return false;
    //         }
    //     }
      
    //     $auth = isset($_GET['zdId']) ? $_GET['zdId'] : $this->baseUser;
        
    //     $editTkt = array("ticket" => array(
    //             "status" => "hold",
    //             "comment" => array("body" => $msg, "public"=> false, "author_id" => $auth)));
                
    //     if( isset($notify) ){
    //         $editTkt['ticket']['email_ccs'] = array(array("user_id"=>$notify,"action"=>"put"));
    //     }        
                
    //     $tkt = json_encode($editTkt);
        
    //     $url = $this->baseUrl.'/api/v2/tickets/'.$id.'.json';
    //     $responseOk = $this->putData( $url, $tkt);
        
    //     if( isset($notify) ){
    //         $editTkt = array("ticket" => array(
    //             "email_ccs" => array(array("user_id"=>$notify,"action"=>"delete"))));
    //         $tkt = json_encode($editTkt);
    //         $responseOk = $this->putData( $url, $tkt);
    //     } 
        
    //     return true;
    // }
    
    public function newTicketSend( $params ){
        
        // $params debe o contener
        // title, msg || html_body, requester
        // puede incluir
        // cc, group, tags, submitter_id, status, assignee_id, public, author_id
        
        $newTicket = array("ticket" => array("subject" => $params['title'], 
                "submitter_id" => $params['submitter_id'] ?? $this->baseUser,
                "group_id" => $params['group'] ?? $this->baseGroup,
                "recipient" => $params['recipient'] ?? 'reservations@adh.com',
                "comment" => array("public" => $params['public'] ?? false, "author_id" => $params['author_id'] ?? $this->baseUser)));
                
        if( isset($params['html_body']) ){
            $newTicket['ticket']['comment']['html_body'] = $params['html_body'];
        }else{
            $newTicket['ticket']['comment']['body'] = $params['msg'];
        }
        
        if( isset($params['requester']) ){
            $newTicket['ticket']['requester_id'] = $params['requester'];
        }
        
        if( isset($params['requesterNew']) ){
            $newTicket['ticket']['requester'] = $params['requesterNew'];
        }

        if( isset($params['tags']) ){
            $newTicket['ticket']['tags'] = $params['tags'];
        }
        
        if( isset($params['assignee_id']) ){
            $newTicket['ticket']['assignee_id'] = $params['assignee_id'];
        }elseif( isset($params['assignee_email']) ){
            $newTicket['ticket']['assignee_email'] = $params['assignee_email'];
        }
                
        if( isset($params['cc']) ){
            $newTicket['ticket']['email_ccs'] = $params['cc'];
        }
                
        if( isset($params['followers']) ){
            $newTicket['ticket']['followers'] = array();
            foreach( $params['followers'] as $follower => $f ){
                array_push($newTicket['ticket']['followers'], ["user_email"=>$f, "action"=>"put"]);
            }
        }
                
        if( isset($params['custom_fields']) ){
            $newTicket['ticket']['custom_fields'] = $params['custom_fields'];
        }
                
        if( isset($params['ticket_form_id']) ){
            $newTicket['ticket']['ticket_form_id'] = $params['ticket_form_id'];
        }   

        $tkt = json_encode($newTicket);
        $response = $this->postData( $this->baseUrl.'/api/v2/tickets.json', $tkt);
        
        // okResp('ticket', 'data', $response, 'params', $newTicket);
        
        if( isset($response['data']->{'ticket'}) ){
            $id = $response['data']->{'ticket'}->{'id'};
            
            return $id;
        }else{
            return $response;
        }
    }
    
    public function newTicket( $title, $openMsg, $requester, $cc = null, $group = null ){

        if( $group == null ){ $grupo = $this->baseUser; }
        
        $newTicket = array("ticket" => array("subject" => $title, 
                "requester_id" => $requester,
                "submitter_id" => $this->baseUser,
                "group_id" => $group,
                "comment" => array("body" => $openMsg, "public" => false, "author_id" => $this->baseUser)));
                
        if( $cc != null ){
            $newTicket['ticket']['email_ccs'] = $cc;
        }

        $tkt = json_encode($newTicket);
        $response = $this->postData( $this->baseUrl.'/api/v2/tickets.json', $tkt);
        
        $id = $response['data']->{'ticket'}->{'id'};
        
        return $id;
    }
    
    public function addComment( $id, $tktData ){
        
        $tkt = json_encode( $tktData );
        
        $url = $this->baseUrl.'/api/v2/tickets/'.$id.'.json';
        $responseOk = $this->putData( $url, $tkt);
        
        return $responseOk;
    }
    
    public function getTalkStatus( $ag ){
        $url = $this->baseUrl."/api/v2/channels/voice/availabilities/$ag";
        
        return $this->getData( $url );
    }

    public function getTicket( $ticket ){
        return $this->getData( "api/v2/tickets/".$ticket );
    }
    
    public function setTalkStatus( $ag, $st ){
        $url = $this->baseUrl."/api/v2/channels/voice/availabilities/$ag.json";
        
        $params = array(
                  "availability"=> array(
                        "agent_state"   => $st,
                        "via"           => "client"
                      )
                );
        
        
        return $this->putData( $url, $params );
    }
    
    public function queueStatus(){
        return $this->getData( $this->baseUrl.'/api/v2/channels/voice/stats/agents_activity.json' );
    }

    public function searchUserByMail( $mail ){
        return $this->getData( '/api/v2/users/search.json?query=email:'.$mail );
    }

    public function crearUsuario($nombre, $correo){

        $params = [
            'user' => [
                'name' => $nombre,
                'email' => $correo,
                "identities" => [
                    [
                      "type" => "email",
                      "value"=> $correo
                    ]
                ],
                "skip_verify_email" => true
            ],
        ];

        return $this->postData( $this->baseUrl.'/api/v2/users', json_encode($params) );
    }

    public function getUser( $id ){
        return $this->getData( '/api/v2/users/'.$id );
    }
    
    public function webhookList(){
        return $this->getData( $this->baseUrl.'/api/v2/webhooks' );
    }
    
    public function webhookProcces( $id ){
        return $this->getData( $this->baseUrl."/api/v2/webhooks/$id/invocations" );
    }
    
    public function webhookAttempt( $w, $i ){
        return $this->getData( $this->baseUrl."/api/v2/webhooks/$w/invocations/$i/attempts" );
    }
    
    public function whRetry( $url, $params ){
        return $this->putData( $url, $params );
    }

}
