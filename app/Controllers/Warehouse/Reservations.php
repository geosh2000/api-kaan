<?php

namespace App\Controllers\Warehouse;

use App\Controllers\BaseController;
use App\Models\Warehouse\ReservationsModel;

class Reservations extends BaseController
{
    public function index()
    {
        $model = new ReservationsModel();

        $data['reservations'] = $model->findAll();

        return view('reservations/index', $data);
    }

    public function show($id)
    {
        $model = new ReservationsModel();

        $data['reservation'] = $model->find($id);

        return view('reservations/show', $data);
    }
}
