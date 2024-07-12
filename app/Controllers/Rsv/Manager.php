<?php

namespace App\Controllers\Rsv;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\ConnectionInterface;

class Manager extends BaseController
{
    public function index()
    {
        return view('/Rsv/Manager/buscador');
    }

    public function search(){

        // Obtener el objeto Request
        $request = service('request');

        // Obtener el valor del campo reservation_number
        $reservationNumber = $request->getPost('reservation_number');

        if($reservationNumber == null){
            return redirect()->to('/rsv/search');
        }

        // Conexión a la base de datos adh_wh
        $db = Config::connect('adh_wh');

        // Consulta SQL para obtener los registros de la tabla RemoteAtelierFrontCRS_Reservations
        $query = $db->table('RemoteAtelierFrontCRS_Reservations')
                    ->where('reservationnumber', $reservationNumber)
                    ->get();

        // Obtener los resultados de la consulta
        $results = $query->getResult();

        // Cargar la vista con los resultados
        return view('Rsv/Manager/results', ['results' => $results]);
    }
}
