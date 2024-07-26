<?php

namespace App\Controllers\Zdapp;

use App\Controllers\BaseController;

class ZendeskAppController extends BaseController
{

    public function index()
    {
        return view('Zendesk/index');
    }

    public function transpo()
    {
        return view('Zendesk/Transfers/index');
    }

   

}
