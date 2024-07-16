<?php

namespace App\Controllers\Transpo;

use App\Models\Transpo\TransportacionesModel;
use App\Models\Transpo\TranspoHistoryModel;
use App\Controllers\BaseController;

class TransportacionController extends BaseController
{

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

    public function store( $hasData = false, $data = [])
    {
        if( !$hasData ){
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
                'tickets' => $this->request->getPost('tickets'),
            ];
    
            // Validar los campos del formulario si es necesario
            $validation = \Config\Services::validation();
            $validation->setRules([
                // Define las reglas de validación aquí, por ejemplo:
                'shuttle' => 'required',
                'hotel' => 'required',
                'tipo' => 'required',
                'folio' => 'required',
                'date' => 'required|valid_date',
                'pax' => 'required|integer',
                'guest' => 'required',
                'time' => 'required',
                'flight' => 'required',
                'airline' => 'required',
                'status' => 'required',
                'tickets' => 'required',
                'precio' => 'required|numeric',
                'correo' => 'required|valid_email',
            ]);
    
            if (!$validation->run($data)) {
                return redirect()->back()->withInput()->with('error', json_encode($validation->getErrors()));
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
        // Redirigir al formulario de edición del registro recién creado
        return redirect()->to(site_url('transpo/edit/' . $lastInsertId))->with('success', 'Nueva reserva '.$lastInsertId.' creada correctamente.');
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

    public function showForm(){
        return view('transpo/form-transfer');
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
                'pax' => $this->request->getPost('pax'),
                'guest' => $this->request->getPost('guest'),
                'date' => $this->request->getPost('arrival-date'),
                'time' => $this->request->getPost('arrival-time'),
                'flight' => $this->request->getPost('arrival-flight-number'),
                'airline' => $this->request->getPost('arrival-airline'),
                'precio' => $this->request->getPost('hotel') == "ATELIER" ? 1213.71 : 470,
                'status' => $this->request->getPost('pago') == 'cortesia' ? 'CORTESÍA (CAPTURA PENDIENTE)' : 'PAGO PENDIENTE',
                'correo' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'tickets' => $this->request->getPost('tickets'),
            ],
            'departure' => [
                'shuttle' => "QWANTOUR",
                'hotel' => $this->request->getPost('hotel'),
                'tipo' => "SALIDA",
                'folio' => $this->request->getPost('folio'),
                'pax' => $this->request->getPost('pax'),
                'guest' => $this->request->getPost('guest'),
                'date' => $this->request->getPost('departure-date'),
                'time' => $this->request->getPost('departure-time'),
                'flight' => $this->request->getPost('departure-flight-number'),
                'airline' => $this->request->getPost('departure-airline'),
                'pick_up' => $this->request->getPost('pickup-time'),
                'precio' => $this->request->getPost('hotel') == "ATELIER" ? 1213.71 : 470,
                'status' => $this->request->getPost('pago') == 'cortesia' ? 'CORTESÍA (CAPTURA PENDIENTE)' : 'PAGO PENDIENTE',
                'correo' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'tickets' => $this->request->getPost('tickets'),
            ],
        ];

        $existing = $this->checkExists($this->request->getPost('folio'));

        if( $existing != null ){
            return redirect()->to(site_url('public/invalid_form'))->with('error', 'El registro ya existe, si necesitas cambios por favor solicítalos a reservations@adh.com <hr> This reservation already exists. If you need to do changes on it, please contact us to reservations@adh.com');
        }

        if( $data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-airport-hotel' ){
            $this->store(true, $data['arrival']);
        }

        if( $data['trip-type'] == 'round-trip' || $data['trip-type'] == 'one-way-hotel-airport' ){
            $this->store(true, $data['departure']);
        }

        return view('transpo/completed', ['hotel' => $this->request->getPost('hotel')]);

        gg_response(200, $data);
    }

    public function invalid(){
        return view('transpo/invalid_form');
    }

    private function checkExists( $folio ){

        $model = new TransportacionesModel();
        $rsv = $model->where('folio',$folio)->findAll();

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

}
