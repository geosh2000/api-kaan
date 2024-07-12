<?php

namespace App\Controllers\Zd;

use App\Controllers\BaseController;
use App\Libraries\Zendesk;

class Objects extends BaseController{

    protected $zd;
    protected $custom_fields;

    public function __construct(){
        $this->zd = new Zendesk();

        $this->custom_fields = [
            "bloqueo" => 26270545805588
        ];
    }

    
    public function index(){
        
        $result = $this->getBloqueo( "01HWZVP9HY0HR3SCDRDZA3CDVC" );

        gg_response(200, $result);
        
    }

    public function getBloqueo( $record_id ){
        $object_key = "bloqueo_grupo";
        
        $result = $this->zd->getData( "api/v2/custom_objects/".$object_key."/records/".$record_id );

        return $result['data']->custom_object_record;
    }

    public function getRlDeadline( $record ){
        $bloqueo = $this->getBloqueo($record);

        $deadline = $bloqueo->custom_object_fields->deadline_roomlist;

        return $deadline;
    }
}
