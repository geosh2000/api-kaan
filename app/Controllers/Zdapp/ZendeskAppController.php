<?php

namespace App\Controllers\Zdapp;

use App\Controllers\BaseController;

class ZendeskAppController extends BaseController
{

    public function index()
    {
        $token = $_POST['token'];
        $qs = $_SERVER['QUERY_STRING'];
        return view('Zendesk/index', ['token' => $token, "qs" => $qs]);
    }

    public function transpo()
    {
        $token = $_POST['token'];
        $qs = $_SERVER['QUERY_STRING'];
        return view('Zendesk/Transfers/index', ['token' => $token, "qs" => $qs]);
    }

    public function confirms()
    {
        $token = $_POST['token'];
        $qs = $_SERVER['QUERY_STRING'];

        return view('Zendesk/Confirm/index', ['token' => $token, "qs" => $qs]);
    }

    public function quote()
    {
        $token = $_POST['token'];
        $qs = $_SERVER['QUERY_STRING'];

        // Obtener la instancia de la base de datos
        $db = \Config\Database::connect('production');

        // Realizar el query
        $query = $db->table('discount_codes')
                    ->get();

        // Obtener los resultados como un array de objetos
        $results = $query->getResultArray();

        $codes = [];
        foreach($results as $row => $d){
            if( isset($codes[$d['hotel_id']]) ){
                $codes[$d['hotel_id']][$d['category_name']] = [ "code" => $d['code'], "descuento" => $d['discount_percentage'] ];
            }else{
                $codes[$d['hotel_id']] = [
                    $d['category_name'] => [ "code" => $d['code'], "descuento" => $d['discount_percentage'] ]
                ];
            }
        }

        return view('Zendesk/Quote/index', ['token' => $token, "qs" => $qs, "codes" => $codes]);
    }



   

}
