<?php

namespace App\Controllers\General;

use App\Controllers\BaseController;

class WelcomeController extends BaseController
{

    public function index()
    {
        return view('Welcome/index');
    }

}