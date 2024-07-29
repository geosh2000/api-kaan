<?php

namespace App\Controllers\Transpo;

use App\Models\Transpo\TransportacionesModel;
use App\Models\Transpo\TranspoHistoryModel;
use App\Controllers\BaseController;
use App\Controllers\Zd\Mailing;
use App\Libraries\Zendesk;
use Config\Globals as templates;

class TransportacionController extends BaseController
{

    private function mapHotel( $h ){
        // Convertimos la cadena a minúsculas para una comparación insensible a mayúsculas/minúsculas
        $lowerText = strtolower($h);

        // Comprobamos si el texto contiene 'leo'
        if (strpos($lowerText, 'olcp') !== false) {
            return 'OLEO';
        }

        // Comprobamos si el texto contiene 'leo'
        if (strpos($lowerText, 'leo') !== false) {
            return 'OLEO';
        }

        // Comprobamos si el texto contiene 'atelier'
        if (strpos($lowerText, 'atpm') !== false) {
            return 'ATELIER';
        }

        // Comprobamos si el texto contiene 'atelier'
        if (strpos($lowerText, 'atelier') !== false) {
            return 'ATELIER';
        }

        // Si no se encuentra ninguna coincidencia, devolvemos el texto original o un valor por defecto
        return $h;
    }

    public function index()
    {
        $model = new TransportacionesModel();

        // Procesar los filtros
        $inicio = $this->request->getVar('inicio') ?? date('Y-m-d');
        $fin = $this->request->getVar('fin') ?? date('Y-m-d', strtotime($inicio . ' +1 month')); // Fecha máxima
        $status_raw = $this->request->getVar('status'); // Todos menos cancelado
        $hotel_raw = $this->request->getVar('hotel');
        $tipo_raw = $this->request->getVar('tipo');
        $guest = $this->request->getVar('guest');
        $correo = $this->request->getVar('correo');
        $folio = $this->request->getVar('folio');

        if( $inicio == "" ){ $inicio = false; }
        if( $fin == "" ){ $fin = false; }

        // Convertir a array si es nulo o un solo valor
        $status = is_null($status_raw) ? [] : $status_raw;
        $hotel = is_null($hotel_raw) ? [] : $hotel_raw;
        $tipo = is_null($tipo_raw) ? [] : $tipo_raw;

        // Consulta de la base de datos con filtros
        $data['transpo'] = $model->getFilteredTransportaciones($inicio, $fin, $status, $hotel, $tipo, $guest, $correo, $folio);


        // Configuración de la paginación
        $pager = \Config\Services::pager();
        $page = (int)$this->request->getVar('page_table1') ?? 1;
        $perPage = 50;
        $model->paginate($perPage, 'table1', $page);

        // Pasar el objeto Pager a la vista
        $data['pager'] = $pager;

        // Definir valores predeterminados si no se proporcionan
        $data['inicio'] = $inicio;
        $data['fin'] = $fin;
        $data['status'] = $status;
        $data['hotel'] = $hotel;
        $data['tipo'] = $tipo;
        $data['guest'] = $guest;
        $data['correo'] = $correo;
        $data['folio'] = $folio;
        $data['title'] = "Transportaciones ADH";

        return view('transpo/index', $data);
    }

    public function create()
    {
        // Mostrar formulario de creación
        return view('transpo/edit', ['transpo' => []]);
    }

    public function store( $hasData = false, $data = [], $html = true)
    {
        if( !$hasData ){
            // Obtener los datos del formulario
            $data = [
                'shuttle' => $this->request->getPost('shuttle') ?? 'QWANTOUR',
                'hotel' => $this->mapHotel($this->request->getPost('hotel')),
                'tipo' => $this->request->getPost('tipo'),
                'folio' => $this->request->getPost('folio'),
                'date' => $this->request->getPost('date'),
                'pax' => $this->request->getPost('pax'),
                'guest' => $this->request->getPost('guest'),
                'time' => $this->request->getPost('time'),
                'flight' => $this->request->getPost('flight'),
                'airline' => $this->request->getPost('airline'),
                'pick_up' => $this->request->getPost('pick_up'),
                'status' => $this->request->getPost('status'),
                'precio' => $this->request->getPost('precio'),
                'correo' => $this->request->getPost('correo'),
                'phone' => $this->request->getPost('phone'),
                'tickets' => $this->request->getPost('tickets'),
                'item' => $this->request->getPost('item'),
                'crs_id' => $this->request->getPost('crs_id'),
                'pms_id' => $this->request->getPost('pms_id'),
                'agency_id' => $this->request->getPost('agency_id'),
                'ticket_payment' => $this->request->getPost('ticket_payment'),
                'ticket_pago' => $this->request->getPost('ticket_pago'),
                'ticket_sent_request' => $this->request->getPost('ticket_sent_request'),
            ];
    
            // Validar los campos del formulario si es necesario
            $validation = \Config\Services::validation();
            $validation->setRules([
                // Define las reglas de validación aquí, por ejemplo:
                'shuttle' => 'required',
                'hotel' => 'required',
                'tipo' => 'required',
                'folio' => 'required',
                'guest' => 'required',
                'status' => 'required',
                'correo' => 'required|valid_email',
            ]);
    
            if (!$validation->run($data)) {
                if( $html ){
                    return redirect()->back()->withInput()->with('error', json_encode($validation->getErrors()));
                }else{
                    gg_response(400, ['error' => json_encode($validation->getErrors())]);
                }
            }
        }

        // Guardar los datos en la base de datos
        $transpoModel = new TransportacionesModel();
        $transpoModel->insert($data);

        // Obtener el ID del registro recién creado
        $lastInsertId = $transpoModel->getInsertID();

        $updateModel = new TranspoHistoryModel();
        $updateModel->create($lastInsertId, false, $hasData ? 'cliente' : "");

        if( $hasData ){
            return true;
        }

        if( $html ){
            // Redirigir al formulario de edición del registro recién creado
            return redirect()->to(site_url('transpo/edit/' . $lastInsertId))->with('success', 'Nueva reserva '.$lastInsertId.' creada correctamente.');
        }else{
            gg_response(200, ['id' => $lastInsertId]);
        }
    }

    public function storeRound()
    {

        // Obtener los datos del formulario
        $data = [
            'shuttle' => $_POST['shuttle'] ?? 'QWANTOUR',
            'hotel' => $this->mapHotel($_POST['hotel'] ?? null),
            'folio' => $_POST['folio'] ?? null,
            'isIncluida' => $_POST['isIncluida'] ?? null,
            'guest' => $_POST['guest'] ?? null,
            'correo' => $_POST['correo'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'pax' => $_POST['pax'] ?? null,
            'item' => $_POST['item'] ?? null,
            'crs_id' => $_POST['crs_id'] ?? null,
            'pms_id' => $_POST['pms_id'] ?? null,
            'agency_id' => $_POST['agency_id'] ?? null,
            'tickets' => $_POST['tickets'] ?? null,
            'ticket_payment' => $_POST['ticket_payment'] ?? null,
            'ticket_pago' => $_POST['ticket_pago'] ?? null,
            'ticket_sent_request' => $_POST['ticket_sent_request'] ?? null,
            'status' => $_POST['status'] ?? null,
            'date_in' => $_POST['date_in'] ?? null,
            'time_in' => $_POST['time_in'] ?? null,
            'flight_in' => $_POST['flight_in'] ?? null,
            'airline_in' => $_POST['airline_in'] ?? null,
            'pick_up_in' => $_POST['pick_up_in'] ?? null,
            'precio_in' => $_POST['precio_in'] ?? $this->mapHotel($_POST['hotel'] ?? null) == 'ATELIER' ? 1213.71 : 470,
            'date_out' => $_POST['date_out'] ?? null,
            'time_out' => $_POST['time_out'] ?? null,
            'flight_out' => $_POST['flight_out'] ?? null,
            'airline_out' => $_POST['airline_out'] ?? null,
            'pick_up_out' => $_POST['pick_up_out'] ?? null,
            'precio_out' => $_POST['precio_out'] ?? $this->mapHotel($_POST['hotel'] ?? null) == 'ATELIER' ? 1213.71 : 470,
            'user' => $_POST['user'] ?? null,
        ];

        $in = [
            'shuttle' => $data['shuttle'],
            'hotel' => $data['hotel'],
            'folio' => $data['folio'],
            'isIncluida' => $data['isIncluida'],
            'guest' => $data['guest'],
            'correo' => $data['correo'],
            'phone' => $data['phone'],
            'pax' => $data['pax'],
            'item' => $data['item'],
            'crs_id' => $data['crs_id'],
            'pms_id' => $data['pms_id'],
            'agency_id' => $data['agency_id'],
            'tickets' => $data['tickets'],
            'ticket_payment' => $data['ticket_payment'],
            'ticket_pago' => $data['ticket_pago'],
            'ticket_sent_request' => $data['ticket_sent_request'],
            'status' => $data['status'],
            'item' => 1,
            'tickets' => "[]",
        ];

        $out = $in;

        $in['precio'] = $data['precio_in'];
        $out['precio'] = $data['precio_out'];

        $in['tipo'] = "ENTRADA";
        $in['date'] = $data['date_in'];
        $in['time'] = $data['time_in'];
        $in['flight'] = $data['flight_in'];
        $in['airline'] = $data['airline_in'];
        $in['pick_up'] = $data['pick_up_in'];
        
        $out['tipo'] = "SALIDA";
        $out['date'] = $data['date_out'];
        $out['time'] = $data['time_out'];
        $out['flight'] = $data['flight_out'];
        $out['airline'] = $data['airline_out'];
        $out['pick_up'] = $data['pick_up_out'];


        // Guardar los datos en la base de datos
        $transpoModel = new TransportacionesModel();
        $updateModel = new TranspoHistoryModel();
        
        try{
            // INSERT IN
            $transpoModel->insert($in);
            $lastInsertIdIn = $transpoModel->getInsertID();
            
            // INSERT OUT
            $transpoModel->insert($out);
            $lastInsertIdOut = $transpoModel->getInsertID();
            
            $updateModel->create($lastInsertIdIn, false, $data['user']);
            $updateModel->create($lastInsertIdOut, false, $data['user']);
    
            gg_response(200, ['ids' => [$lastInsertIdIn, $lastInsertIdOut]]);
        }catch (\mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                // Error de entrada duplicada
                gg_response(400, ['msg' => 'Registro ya existe'] );
            } else {
                // Otros errores de base de datos
                gg_response(400, ['msg' => 'Error de base de datos'] );
            }
        } catch (\Exception $e) {
            gg_response(400, ['msg' => 'Ha ocurrido un error inesperado'] );
        }
    }


    public function edit($id)
    {

        $model = new TransportacionesModel();

        // Obtener los datos de la transportación
        $data['transpo'] = $model->where('id',$id)->first();

        // Cargar la vista de edición
        return view('transpo/edit', $data);
    }

    public function update($id)
    {
        $model = new TransportacionesModel();

        // Obtener valores originales
        $before = $model->where('id',$id)->first();

        // Obtener los datos del formulario
        $data = [
            'shuttle' => $this->request->getPost('shuttle'),
            'hotel' => $this->request->getPost('hotel'),
            'tipo' => $this->request->getPost('tipo'),
            'folio' => $this->request->getPost('folio'),
            'date' => $this->request->getPost('date'),
            'pax' => $this->request->getPost('pax'),
            'guest' => $this->request->getPost('guest'),
            'time' => $this->request->getPost('time'),
            'flight' => $this->request->getPost('flight'),
            'airline' => $this->request->getPost('airline'),
            'pick_up' => $this->request->getPost('pick_up'),
            'status' => $this->request->getPost('status'),
            'precio' => $this->request->getPost('precio'),
            'correo' => $this->request->getPost('correo'),
            'phone' => $this->request->getPost('phone'),
            'newTicket' => $this->request->getPost('newTicket') ?? "",
        ];

        $beforeTickets = json_decode($before['tickets']);

        if( $data['newTicket'] != "" ){
            if( !in_array($data['newTicket'], $beforeTickets) ){
                array_push($beforeTickets, $data['newTicket']);
            }
        }

        $data['tickets'] = json_encode($beforeTickets);
        unset($data['newTicket']);

        // Actualizar los datos en la base de datos
        if ($model->builder()
                ->where('id', $id)
                ->update($data)) {
              
            $updateFields = [];

            foreach( $data as $field => $val ){
                if( $val != $before[$field] ){
                    array_push($updateFields, [$field, $before[$field], $val]);
                }
            }

            $data['transpo'] = $model->where('id',$id)->first();
            $data['success_modal'] = true; // Marcar que se debe mostrar el modal de éxito

            if( count($updateFields) > 0 ){
                $updateModel = new TranspoHistoryModel();
                $updateModel->edit($id, $updateFields);
            }
            return redirect()->back()->with('success', 'Cambios guardados correctamente.');
        } else {
            // Si hay un error, redirigir a la página de edición con un mensaje de error
            return redirect()->back()->with('error', 'Error al guardar los cambios.');
        }

    
    }

    public function editStatus($id, $s)
    {
        $model = new TransportacionesModel();

        // Obtener valores originales
        $before = $model->where('id',$id)->first();

        // Obtener los datos del formulario
        $data = [
            'status' => $s
        ];

        // Actualizar los datos en la base de datos
        if ($model->builder()
                ->where('id', $id)
                ->update($data)) {
            // Mostrar la página de edición con un modal de éxito
            
            $updateFields = [];

            foreach( $data as $field => $val ){
                if( $val != $before[$field] ){
                    array_push($updateFields, [$field, $before[$field], $val]);
                }
            }

            $data['transpo'] = $model->where('id',$id)->first();
            $data['success_modal'] = true; // Marcar que se debe mostrar el modal de éxito

            if( count($updateFields) > 0 ){
                $updateModel = new TranspoHistoryModel();
                $updateModel->edit($id, $updateFields);
            }
            return redirect()->back()->with('success', 'Cambios guardados correctamente.');
        } else {
            // Si hay un error, redirigir a la página de edición con un mensaje de error
            return redirect()->back()->with('error', 'Error al guardar los cambios.');
        }

    
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        $transpoModel = new TransportacionesModel();
        $transpo = $transpoModel->where('id',$id)->first();

        if (!$transpo) {
            return redirect()->to(site_url('transpo/reservation'))->with('error', 'Registro no encontrado.');
        }

        return view('transpo/confirm_delete', ['transpo' => $transpo]);
    }

    public function delete($id)
    {
        $transpoModel = new TransportacionesModel();

        // Intentar eliminar el registro
        if ($transpoModel->where('id',$id)->delete()) {
            // Si la eliminación es exitosa, redirigir con un mensaje de éxito
            return redirect()->to(site_url('transpo').'?'.$_SERVER['QUERY_STRING'])
                ->with('success', 'Registro '.$id.' Borrado');
        } else {
            return redirect()->to(site_url('transpo').'?'.$_SERVER['QUERY_STRING'])
                ->with('error', 'Registro no encontrado.');
        }
    }

    public function showForm( $json = false, $encoded = null ){

        $encoded = $encoded ?? $_GET['d'];
        $lang = ($_GET['lang'] ?? 'esp') == 'esp';
        $json = boolval($json);

        
        if (isset($encoded)) {
            // Decodificar el JSON de base64
            $encodedData = $encoded;
            $jsonData = base64_decode($encodedData);
            
            // Decodificar el JSON en un array asociativo
            $data = json_decode($jsonData, true);
            
            // Verificar si la decodificación fue exitosa y que el JSON sea válido
            if ($data === null) {
                return view('/transpo/invalid_form.php');
            }
        }else{
            return view('/transpo/invalid_form.php');
        }
        
        
        // Verifica status de reserva
        $ids = $data['ids'];
        $model = new TransportacionesModel();
        
        $rsva = $model->searchAllIds($ids);
        $info = [];
        foreach( $rsva as $r => $t ){
            $info[$t['tipo']] = $t;
        }
        
        $params = ['lang' => $lang, 'rsva' => $info, 'data' => $data, 'hotel' => ($data['hotel'] == 'ATELIER') ? 'atpm' : 'oleo'];

        if($json){
            gg_response(200, [$params]);
        }

        return view('transpo/form-transfer', $params);
    }

    public function storeForm(){

        // Obtener los datos del formulario
        $data = [
            'trip-type' => $this->request->getPost('trip-type'),
            'arrival' => [
                'shuttle' => "QWANTOUR",
                'hotel' => $this->request->getPost('hotel'),
                'tipo' => "ENTRADA",
                'folio' => $this->request->getPost('folio'),
                'item' => $this->request->getPost('item'),
                'pax' => $this->request->getPost('pax'),
                'guest' => $this->request->getPost('guest'),
                'date' => $this->request->getPost('arrival-date'),
                'time' => $this->request->getPost('arrival-time'),
                'flight' => $this->request->getPost('arrival-flight-number'),
                'airline' => $this->request->getPost('arrival-airline'),
                'precio' => $this->request->getPost('hotel') == "ATELIER" ? 1213.71 : 470,
                'status' => $this->request->getPost('pago') == 'cortesia' ? 'CORTESÍA (CAPTURA PENDIENTE)' : 'LIGA PENDIENTE',
                'phone' => $this->request->getPost('phone'),
                'tickets' => $this->request->getPost('tickets') ?? "[]",
            ],
            'departure' => [
                'shuttle' => "QWANTOUR",
                'hotel' => $this->request->getPost('hotel'),
                'tipo' => "SALIDA",
                'folio' => $this->request->getPost('folio'),
                'item' => $this->request->getPost('item'),
                'pax' => $this->request->getPost('pax'),
                'guest' => $this->request->getPost('guest'),
                'date' => $this->request->getPost('departure-date'),
                'time' => $this->request->getPost('departure-time'),
                'flight' => $this->request->getPost('departure-flight-number'),
                'airline' => $this->request->getPost('departure-airline'),
                'pick_up' => $this->request->getPost('pickup-time'),
                'precio' => $this->request->getPost('hotel') == "ATELIER" ? 1213.71 : 470,
                'status' => $this->request->getPost('pago') == 'cortesia' ? 'CORTESÍA (CAPTURA PENDIENTE)' : 'LIGA PENDIENTE',
                'phone' => $this->request->getPost('phone'),
                'tickets' => $this->request->getPost('tickets') ?? "[]",
            ],
        ];

        $noRestrict = boolval($this->request->getPost('noRestrict') ?? 0);

        $existing = $this->checkExists($this->request->getPost('folio'), $this->request->getPost('item'));

        $model = new TransportacionesModel();

        $validate = [
            ($data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-airport-hotel') ? $data['arrival']['date'] : $data['departure']['date'],
            ($data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-hotel-airport') ? $data['departure']['date'] : $data['arrival']['date'],
            $this->request->getPost('pago') == 'cortesia' ? 2 : 3
        ];

        if( !$noRestrict ){
            if( !$model->validFormDate( $validate ) ){
                return redirect()->to(site_url('public/invalid_form'))->with('error', 'La fecha elegida ya no es posible programarla debido a que el proveedor de nuestra transportación nos pide un mínimo de 3 días de anticipación.<hr>The chosen date is no longer possible to schedule because our transportation provider requires a minimum of 3 days');
            }
        }


        if( $data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-airport-hotel' ){
            if( $existing != null ){
                foreach($existing as $r => $t){
                    if( $t['tipo'] == 'ENTRADA'){
                        if( strpos($t['status'], 'SOLICITADO') !== false ){
                            $model->updateById($t['id'],$data['arrival']);
                        }else{
                            return redirect()->to(site_url('public/invalid_form'))->with('error', 'El registro ya existe o tiene errores. Si necesitas cambios, por favor comunícate con reservations@adh.com <hr> This reservation already exists or has errors on it. If you need to do changes on it, please contact us to reservations@adh.com');
                        }
                    }
                }
            }
        }

        if( $data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-hotel-airport' ){
            foreach($existing as $r => $t){
                if( $t['tipo'] == 'SALIDA'){
                    if( strpos($t['status'], 'SOLICITADO') !== false ){
                        $model->updateById($t['id'],$data['departure']);
                    }else{
                        return redirect()->to(site_url('public/invalid_form'))->with('error', 'El registro ya existe o tiene errores. Si necesitas cambios, por favor comunícate con reservations@adh.com <hr> This reservation already exists or has errors on it. If you need to do changes on it, please contact us to reservations@adh.com');
                    }
                }
            }
        }

        return view('transpo/completed', ['hotel' => $this->request->getPost('hotel')]);

        gg_response(200, $data);
    }

    public function invalid(){
        return view('transpo/invalid_form');
    }

    private function checkExists( $folio, $item ){

        $model = new TransportacionesModel();
        $rsv = $model
            ->where('folio',$folio)
            ->where('item', $item)
            ->findAll();

        return $rsv;
    }

    private function validateCort($folio){
        
        $db = db_connect('adh_crs');
        
        // Obtiene reservas hechas en los ultimos dias y llegadas de los próximos 10 con transpo incluida
        $query = "SELECT 
                    CASE WHEN htl.Name LIKE '%atelier playa mujeres%' THEN 'ATELIER'
                    WHEN htl.Name LIKE '%Óleo Cancún Playa%' THEN 'OLEO'
                    ELSE htl.Name END as Hotel, ReservationNumber, DateFrom, DateTo, 
                    CONCAT(rsv.Adults,'.',COALESCE(rsv.Children,0)+COALESCE(rsv.Teens,0)+COALESCE(rsv.Infants,0)) as pax,
                    CONCAT(rsv.Name,' ',rsv.LastName) as Guest, 
                    rsv.Email as Email, DateCancel
                FROM 
                    [dbo].[Reservations] rsv
                    LEFT JOIN [dbo].[Hotels] htl ON rsv.HotelId=htl.HotelId
                    LEFT JOIN [dbo].[Agencies] agn ON rsv.AgencyId=agn.AgencyId
                WHERE 
                    ReservationNumber = $folio";

        $rsv = $db->query($query);
        $result = $rsv->getResultArray();

        if( count($result) > 0 ){
            return false;
        }else{
            return true;
        }
    }

    public function getHistory($id){
        $history = new TranspoHistoryModel();

        $regs = $history->getAll($id);

        if( count($regs) == 0 ){
            $regs = [
                ['historyId' => '',
                'id' => '',
                'title' => '',
                'comment' => '',
                'user' => '',
                'dtCreated' => ''
                ]
            ];
        }
        
        return view('transpo/history_table', ['history' => $regs]);
    }

    public function removeTicket( $id, $ticket ){
        $model = new TransportacionesModel();

        // Obtener valores originales
        $before = $model->where('id',$id)->first();

        $beforeTickets = json_decode($before['tickets'],true);

        foreach( $beforeTickets as $i => $tkt ){
            if( $tkt == $ticket ){
                unset($beforeTickets[$i]);
                continue;
            }
        }

        $beforeTickets = array_values($beforeTickets);

        $afterTickets = json_encode($beforeTickets);

        $model->builder()
                ->where('id', $id)
                ->update(["tickets" => $afterTickets]);

        $updateModel = new TranspoHistoryModel();
        $updateModel->edit($id, [["Tickets", $before['tickets'], $afterTickets]]);

        gg_response(200, ["msg" => "Ticket $ticket eliminado de registro $id"]);
    }

    public function mailRequest2( $t, $id1, $id2 = 0, $ticket = "123456" ){
        $model = new TransportacionesModel();
        $rsva = $model->where_in('id',[$id1, $id2])->findAll();

        if( count($rsva) == 0 ){
            gg_response(404, ["err" => true, "msg" => "No se encontro ninguna reserva"]);
        }

        if( count($rsva) > 1 ){
            $incons = "datos de reservas no son consistentes";
            if( $rsva[0]['guest'] != $rsva[1]['guest'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['folio'] != $rsva[1]['folio'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['hotel'] != $rsva[1]['hotel'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['correo'] != $rsva[1]['correo'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            $id2 = $rsva[1]['id'];
        }else{
            $id2 = 0;
        }

        $lang = ($_GET['lang'] ?? 'esp') == 'esp';
        $hotel = strtolower($rsva['hotel'] ?? 'atpm');

        return view('transpo/mailing/transpoRequest', ['data' => $rsva[0], 'ids' => [$rsva[0]['id'], $id2], 'token' => $this->encodeLink($rsva, $ticket, [$rsva[0]['id'], $id2]), 'hotel' => ($hotel == 'ATELIER') ? 'atpm' : 'oleo', 'lang' => $lang]);
    }

    public function mailRequest(){

        if( !isset( $_POST['ticket'] ) ){
            gg_response(400, ['msg' => "Ticket requerido"]);
        }

        $id1 = $_POST['id1'] ?? 0;
        $id2 = $_POST['id2'] ?? 0;
        $ticket = $_POST['ticket'];
        $lang = $_POST['lang'] ?? 0;
        $author = $_POST['author'] ?? 0;
        $noRestrict = $_POST['noRestrict'] ?? 0;


        $model = new TransportacionesModel();
        $rsva = $model->whereIn('id',[$id1, $id2])->findAll();

        if( count($rsva) == 0 ){
            gg_response(404, ["err" => true, "msg" => "No se encontro ninguna reserva"]);
        }

        if( count($rsva) > 1 ){
            $incons = "datos de reservas no son consistentes";
            if( $rsva[0]['guest'] != $rsva[1]['guest'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['folio'] != $rsva[1]['folio'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['hotel'] != $rsva[1]['hotel'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['correo'] != $rsva[1]['correo'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            $id2 = $rsva[1]['id'];
        }else{
            $id2 = 0;
        }

        switch( $lang ){
            case 'es-419':
                $lang = 'esp';
                break;
            case 'en-US':
                $lang = 'eng';
                break;
            default: 
                $lang = 'eng';
                break;
        }

        $zd = new Zendesk();
        
        // Reemplaza las variables en el HTML con valores específicos
        if( $noRestrict == "1" ){
            return $this->showForm( false, $this->encodeLink($rsva, $ticket, [$rsva[0]['id'], $id2], $noRestrict) );
        }

        $html = view('transpo/mailing/transpoRequest', ['data' => $rsva[0], 'ids' => [$rsva[0]['id'], $id2], 'token' => $this->encodeLink($rsva, $ticket, [$rsva[0]['id'], $id2], $noRestrict), 'hotel' => (strpos(strtolower($rsva[0]['hotel']),'atelier') !== false ? 'atpm' : 'oleo'), 'lang' => $lang == 'esp']);

        $dataTicket = [
            "comment"   =>  [
                "public"        => true,
                "html_body"     => $html,
            ]
        ];

        if($author != 0){ $dataTicket["comment"]["author_id"] = $author; }

        $result = $zd->updateTicket($ticket, $dataTicket);
        
        $request_tickets = json_decode($rsva[0]['ticket_sent_request'] ?? "[]");
        if( !in_array($ticket, $request_tickets) ){
            array_push($request_tickets, $ticket );
        }
        $model->updateById([$id1, $id2], ['status' => $rsva[0]['isIncluida'] == "1" ? 'INCLUIDA (SOLICITADO)' : 'SOLICITADO', 'ticket_sent_request' => json_encode($request_tickets)]);
 
        gg_response($result['response'], ['data' => $result['data'], 'sent' => true, ] );
    }

    public function linkRequest(){

        if( !isset( $_POST['ticket'] ) ){
            gg_response(400, ['msg' => "Ticket requerido"]);
        }

        $id1 = $_POST['id1'] ?? 0;
        $id2 = $_POST['id2'] ?? 0;
        $ticket = $_POST['ticket'];
        $lang = $_POST['lang'] ?? 0;
        $link = $_POST['link'] ?? 0;
        $author = $_POST['author'] ?? 0;

        if( $link == 0 ){
            gg_response(404, ["err" => true, "msg" => "No se obtuvo ninguna liga de pago"]);
        }


        $model = new TransportacionesModel();
        $rsva = $model->whereIn('id',[$id1, $id2])->findAll();

        if( count($rsva) == 0 ){
            gg_response(404, ["err" => true, "msg" => "No se encontro ninguna reserva"]);
        }

        if( count($rsva) > 1 ){
            $incons = "datos de reservas no son consistentes";
            if( $rsva[0]['guest'] != $rsva[1]['guest'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['folio'] != $rsva[1]['folio'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['hotel'] != $rsva[1]['hotel'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            if( $rsva[0]['correo'] != $rsva[1]['correo'] ){ gg_response(404, ["err" => true, "msg" => $incons]); }
            $id2 = $rsva[1]['id'];
        }else{
            $id2 = 0;
        }

        switch( $lang ){
            case 'es-419':
                $lang = 'esp';
                break;
            case 'en-US':
                $lang = 'eng';
                break;
            default: 
                $lang = 'eng';
                break;
        }

        $zd = new Zendesk();
        
        // Reemplaza las variables en el HTML con valores específicos
        $html = view('transpo/mailing/transpoLinkRequest', ['data' => $rsva[0], 'link' => $link, 'ids' => [$rsva[0]['id'], $id2], 'token' => $this->encodeLink($rsva, $ticket, [$rsva[0]['id'], $id2]), 'hotel' => (strpos(strtolower($rsva[0]['hotel']),'atelier') !== false ? 'atpm' : 'oleo'), 'lang' => $lang == 'esp']);

        $dataTicket = [
            "comment"   =>  [
                "public"        => true,
                "html_body"     => $html
            ],
            "custom_status_id" => 27209361873812,
            "custom_fields" => [["id" => 28727761630100, "value" => $link]]
        ];

        if($author != 0){ $dataTicket["comment"]["author_id"] = $author; }

        $result = $zd->updateTicket($ticket, $dataTicket);
        
        $payment_tickets = json_decode($rsva[0]['ticket_payment'] ?? "[]");
        if( !in_array($ticket, $payment_tickets) ){
            array_push($payment_tickets, $ticket );
        }
        $model->updateById([$id1, $id2], ['status' => 'PAGO PENDIENTE', 'ticket_payment' => json_encode($payment_tickets)]);
 
        gg_response($result['response'], ['data' => $result['data'], 'sent' => true, ] );
    }

    private function encodeLink( $rsv, $ticket, $ids, $noRestrict = 0 ){
        $data = [
            "folio" => $rsv[0]['folio'],
            "item" => $rsv[0]['item'],
            "guest" => $rsv[0]['guest'],
            "hotel" => $rsv[0]['hotel'],
            "ticket" => $ticket,
            "email" => $rsv[0]['correo'],
            "pago" => $rsv[0]['isIncluida'] == "1" ? "cortesia" : "pagada",
            "ids" => $ids,
            "noRestrict" => $noRestrict
        ];
        
        // Encode data to JSON
        $jsonData = json_encode($data);        
        $encodedData = base64_encode($jsonData);
        
        return $encodedData;
    }

    public function findByFolio( $id ){
        $model = new TransportacionesModel();
        $rsva = $model->searchAll( $id );

        gg_response(200, ["data" => $rsva]);
    }

    public function findById( $ida, $vuelta ){
        $model = new TransportacionesModel();
        $rsva = $model->searchAllIds( [$ida, $vuelta] );

        gg_response(200, ["data" => $rsva]);
    }

    public function search( $id, $html = true ){
        $model = new TransportacionesModel();
        $rsva = $model->searchComplete( $id );

        if( count($rsva) == 0 ){
            echo "empty";
            return;
        }
        if( $html ){
            return view('Transpo/Lists/rsvList', ["data" => $rsva]);
        }else{
            gg_response(200, ["data" => $rsva]);
        }
    }

}
