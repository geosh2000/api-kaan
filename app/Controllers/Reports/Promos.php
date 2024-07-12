<?php

namespace App\Controllers\Reports;

use App\Controllers\BaseController;

class Promos extends BaseController
{
    public function index()
    {
        // Obtenemos una instancia de la conexión 'adh_crs'
        $db = db_connect('adh_crs');

        // Realiza la consulta a la base de datos
        $query = $db->query('SELECT * FROM Agencies');

        // Obtén los resultados de la consulta como un array de objetos
        $results = $query->getResult();

        // Convertir los resultados a formato JSON
        $json = json_encode($results);

        // Establecer el tipo de contenido de la respuesta como JSON
        return $this->response->setContentType('application/json')
                               ->setBody($json);
    }

    public function promoUk( $view = false ){

        $results = $this->ukStatic();

        if( $view ){
            return view('Crs/Reports/PromoAdjust', ['reservations' => $results]);
        }else{
            return gg_response(200, ["error" => false, "data" => $results]);
        }

    }

    private function ukStatic(){

        // Verificar si la solicitud es de tipo POST
        if ($this->request->getMethod() === 'post') {
            // Obtener los parámetros de fecha_inicio y fecha_fin del cuerpo del POST
            $fecha_inicio = $this->request->getPost('fecha-inicio');
            $fecha_fin = $this->request->getPost('fecha-fin');
        }else{
            // Si no es una solicitud POST, establecer las fechas por defecto
            $fecha_inicio = '2024-04-04';
            $fecha_fin = '2024-05-31';
        }

        // Obtenemos una instancia de la conexión 'adh_crs'
        $db = db_connect('adh_crs');

        $query = "SELECT TOP (1000) 
                        ReservationNumber,
                        ReservationDate,
                        a.AgencyId,
                        a.DateFrom, 
                        a.DateTo,
                        a.Nights,
                        a.Name, a.LastName,
                        b.Name as Agency,
                        a.Adults+a.Teens as Adults,
                        a.Children,
                        a.Infants,
                        c.Code, NetRate, c.Name as Habitacion
                    FROM [dbo].[Reservations] a 
                    LEFT JOIN dbo.Agencies b ON a.AgencyId=b.AgencyId
                    LEFT JOIN dbo.roomtypes c ON a.roomtypeid=c.roomtypeid AND a.HotelId=c.HotelId
                    WHERE 
                    a.AgencyId IN (620,720,804,521,375,378,612,384,621,627,628,629,630,389,631,742,398,399,516,495,478,633,416,418,615,618,624,428,613,432,823,439,634,435,437,438,522,616,708,455,811,461,468,637,470,617,523,786,487,493,625,491,498,619,638,500,506,510,752)
                    AND DateFrom BETWEEN '2024-04-19' AND '2024-09-30'
                    AND ReservationDate BETWEEN '$fecha_inicio' AND '$fecha_fin'
                    AND a.HotelId=13 AND Nights>=4
                    AND c.Code IN ('STD','STK','SSD','JSK','SOD','JOK')
                    GROUP BY ReservationNumber,
                        ReservationDate,
                        a.AgencyId,
                        a.DateFrom, 
                        a.DateTo,
                        a.Nights,
                        a.Name, a.LastName,
                        b.Name,
                        a.Adults+a.Teens,
                        a.Children,
                        a.Infants,
                        c.Code, c.Name, NetRate";

        // Realiza la consulta a la base de datos
        $query = $db->query($query);

        // Obtén los resultados de la consulta como un array de objetos
        $results = $query->getResult();

        // Agregar el campo "DailyRate" a cada reserva
        foreach ($results as &$reserva) {
            $fechas = $this->getDates($reserva->DateFrom, $reserva->DateTo);
            $reserva->DailyRate = array_fill_keys($fechas, 0);

            // Calucular la tarifa diaria de childs
            $dailyChildRate = $reserva->Children * 50;
            $reserva->NEWNetRate = 0;

            foreach( $reserva->DailyRate as $fecha => $rate){
                $reserva->DailyRate[$fecha] = $this->getRate($reserva, $fecha) + $dailyChildRate;
                $reserva->NEWNetRate += $reserva->DailyRate[$fecha];
            }
        }

        return $results;

        
    }

    // Función para obtener las fechas entre dos fechas dadas
    private function getDates($startDate, $endDate) {
        $dates = [];
        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($currentDate < $endDate) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }

    // Funcion para determinar el rateGroup
    private function getRateGroup($date) {
        switch(true) {
            case strtotime($date) >= strtotime('2024-04-19') && strtotime($date) <= strtotime('2024-04-30'):
                return 'a';
            case strtotime($date) >= strtotime('2024-05-01') && strtotime($date) <= strtotime('2024-06-30'):
            case strtotime($date) >= strtotime('2024-08-01') && strtotime($date) <= strtotime('2024-09-30'):
                return 'b';
            case strtotime($date) >= strtotime('2024-07-01') && strtotime($date) <= strtotime('2024-07-31'):
                return 'c';
            default:
                return 'na';
        }
    }

    // Funcion para determinar nivel por noches
    private function getRateNight($nights, $agency) {

        $topLimit = $agency == 384 ? 8 : 10;

        switch(true) {
            case $nights >= 4 && $nights < 7:
                return '4';
            case $nights >= 7 && $nights < $topLimit:
                return '7';
            case $nights >= $topLimit:
                return '10';
            default:
                return 0;
        }
    }

    // Funcion para calcular tarifa de promocion
    private function getRate( $r, $date ){

        $rateGroup = $this->getRateGroup($date);

        if( $rateGroup == 'na' ) return 0;  

        $rateNight = $this->getRateNight( $r->Nights, $r->AgencyId );

        $tarifas = array(
            "a" => array(
                "STD" => array( 
                    "4" => array( "1" => 210, "2" => 247, "3" => 351 ), 
                    "7" => array( "1" => 206, "2" => 242, "3" => 344 ), 
                    "10" => array( "1" => 196, "2" => 230, "3" => 327 )
                 ),
                "STK" => array( 
                    "4" => array( '2' => 257, '1' =>218,'3' => 365 ), 
                    "7" => array( '2' => 252, '1' =>378,'3' => 182 ), 
                    "10" => array( '2' => 240, '1' =>360,'3' => 173 )
                 ),
                "SSD" => array( 
                    "4" => array( '2' => 267, '1' =>227,'3' => 379,'4' => 505 ), 
                    "7" => array( '2' => 262, '1' =>223,'3' => 372,'4' => 495 ), 
                    "10" => array( '2' => 250, '1' =>213,'3' => 355,'4' => 473 )
                 ),
                "JSK" => array( 
                    "4" => array( '2' => 277, '1' =>235,'3' => 393 ), 
                    "7" => array( '2' => 272, '1' =>231,'3' => 386 ), 
                    "10" => array( '2' => 260, '1' =>221,'3' => 369 )
                 ),
                "SOD" => array( 
                    "4" => array( '2' => 287, '1' =>244,'3' => 408,'4' => 542 ), 
                    "7" => array( '2' => 282, '1' =>240,'3' => 400,'4' => 533 ), 
                    "10" => array( '2' => 270, '1' =>230,'3' => 383,'4' => 510 )
                 ),
                "JOK" => array( 
                    "4" => array( '2' => 307, '1' =>261,'3' => 436 ), 
                    "7" => array( '2' => 302, '1' =>257,'3' => 429 ), 
                    "10" => array( '2' => 290, '1' =>247,'3' => 412 )
                 ),
            ),
            "b" => array(
                "STD" => array( 
                    "4" => array( '2' => 203, '1' =>173,'3' => 288 ), 
                    "7" => array( '2' => 200, '1' =>170,'3' => 284 ), 
                    "10" => array( '2' => 190, '1' =>162,'3' => 270 )
                 ),
                "STK" => array( 
                    "4" => array( '2' => 213, '1' =>181,'3' => 302 ), 
                    "7" => array( '2' => 210, '1' =>315,'3' => 150 ), 
                    "10" => array( '2' => 200, '1' =>300,'3' => 143 )
                 ),
                "SSD" => array( 
                    "4" => array( '2' => 223, '1' =>190,'3' => 317,'4' => 421 ), 
                    "7" => array( '2' => 220, '1' =>187,'3' => 312,'4' => 416 ), 
                    "10" => array( '2' => 210, '1' =>179,'3' => 298,'4' => 397 )
                 ),
                "JSK" => array( 
                    "4" => array( '2' => 233, '1' =>198,'3' => 331 ), 
                    "7" => array( '2' => 230, '1' =>196,'3' => 327 ), 
                    "10" => array( '2' => 220, '1' =>187,'3' => 312 )
                 ),
                "SOD" => array( 
                    "4" => array( '2' => 243, '1' =>207,'3' => 345,'4' => 459 ), 
                    "7" => array( '2' => 240, '1' =>204,'3' => 341,'4' => 454 ), 
                    "10" => array( '2' => 230, '1' =>196,'3' => 327,'4' => 435 )
                 ),
                "JOK" => array( 
                    "4" => array( '2' => 263, '1' =>224,'3' => 373 ), 
                    "7" => array( '2' => 260, '1' =>221,'3' => 369 ), 
                    "10" => array( '2' => 250, '1' =>213,'3' => 355 )
                 ),
            ),
            "c" => array(
                "STD" => array( 
                    "4" => array( '2' => 215, '1' =>183,'3' => 305 ), 
                    "7" => array( '2' => 210, '1' =>179,'3' => 298 ), 
                    "10" => array( '2' => 200, '1' =>170,'3' => 284 )
                 ),
                "STK" => array( 
                    "4" => array( '2' => 225, '1' =>191,'3' => 320 ), 
                    "7" => array( '2' => 220, '1' =>330,'3' => 158 ), 
                    "10" => array( '2' => 210, '1' =>315,'3' => 150 )
                 ),
                "SSD" => array( 
                    "4" => array( '2' => 235, '1' =>200,'3' => 334,'4' => 444 ), 
                    "7" => array( '2' => 230, '1' =>196,'3' => 327,'4' => 435 ), 
                    "10" => array( '2' => 220, '1' =>187,'3' => 312,'4' => 416 )
                 ),
                "JSK" => array( 
                    "4" => array( '2' => 245, '1' =>208,'3' => 348 ), 
                    "7" => array( '2' => 240, '1' =>204,'3' => 341 ), 
                    "10" => array( '2' => 230, '1' =>196,'3' => 327 )
                 ),
                "SOD" => array( 
                    "4" => array( '2' => 255, '1' =>217,'3' => 362,'4' => 482 ), 
                    "7" => array( '2' => 250, '1' =>213,'3' => 355,'4' => 473 ), 
                    "10" => array( '2' => 240, '1' =>204,'3' => 341,'4' => 454 )
                 ),
                "JOK" => array( 
                    "4" => array( '2' => 275, '1' =>234,'3' => 391 ), 
                    "7" => array( '2' => 270, '1' =>230,'3' => 383 ), 
                    "10" => array( '2' => 260, '1' =>221,'3' => 369 )
                 ),
            ),
        );

        return $tarifas[$rateGroup][$r->Code][$rateNight][$r->Adults];
    }
}
