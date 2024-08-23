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



   

}
