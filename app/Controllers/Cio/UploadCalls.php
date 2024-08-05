<?php

namespace App\Controllers\Cio;

use App\Controllers\BaseController;
use App\Models\Cio\LlamadasModel;
use App\Libraries\DatabaseUtils;
use App\Helpers\DatabaseHelper;
use CodeIgniter\HTTP\Files\UploadedFile;


class UploadCalls extends BaseController {

    private $arreglo = array(
        "global_id" => "id",
        "Global Id" => "id",
        "date" => "fecha",
        "time" => "hora",
        "cola" => "cola",
        "hotel" => "hotel",
        "idioma" => "idioma",
        "type" => "tipo_llamada",
        "ivr" => "ivr",
        "queue_time" => "tiempo_cola",
        "held" => "tiempo_en_espera",
        "in_sl" => "dentro_del_tiempo_de_espera",
        "scenario" => "escenario",
        "talk" => "duracion_hablada",
        "hold" => "duracion_en_espera",
        "duration" => "duracion_total",
        "from" => "desde",
        "transferred_from" => "transferido_desde",
        "original_destination" => "destino_original",
        "connected_to" => "conectado_a",
        "service__campaign" => "servicio_campana",
        "agent_disposition" => "disposicion_agente",
        "disposition" => "disposicion",
        "notes" => "notas",
        "dialingringing" => "marcado_timbrando",
        "nps" => "nps",
        "fcr" => "fcr",
    );

    public function mostrarFormulario() {
        return view('Cio/upload');
    }

    public function cargarCSV(){
        $file = $this->request->getFile('archivo_csv');

        if ($file->isValid() && $file->getExtension() == 'csv') {
            // Abrir el archivo CSV
            $handle = fopen($file->getTempName(), 'r');

            // Leer la primera fila para obtener los nombres de las columnas
            $columnNames = fgetcsv($handle);

            $data = [];

            // Recorrer cada fila del CSV
            while (($row = fgetcsv($handle)) !== false) {
                // Crear un array asociativo con los nombres de columnas como claves y los valores de la fila
                $rowData = array_combine($columnNames, $row);
                $rowData['Date'] = dateDMAtoSQL($rowData['Date']);
                $rowData['Time'] = hourAMto24($rowData['Time']);

                $data[] = $rowData;
            }

            foreach($data as $key => $value){
                $data[$key] = array_map('trim', $value);
            }

            fclose($handle);
            
            $this->processCalls($data);
        } else {
            // Devolver un mensaje de error si el archivo no es válido o no es un CSV
            gg_response(400, json_encode(['error' => 'El archivo proporcionado no es válido.']));
        }

        
    }

    public function loadCSV(){

        // crear variable de texto con la fecha de hoy en formato YYYYMMDD
        $fecha = date('Ymd');

        // Define URL del archivo
        // $url = 'https://adh.geoshglobal.com/cio/reports/calls/call_detail (7).csv';
        $url = '/home/cycoasis/adh.geoshglobal.com/cio/reports/calls/atelier_calls.csv';
        
        // Verifica si existe el archivo 
        if (!file_exists($url)) {
            gg_response(400, json_encode(['error' => "El archivo $url no existe. ".$_SERVER["HTTP_HOST"]]));
        }

        // obtener file csv desde carpeta en servidor, validando si existen errores al cargarlo 
        $contenido = file_get_contents($url);

        // Separar el contenido del archivo por filas
        $lineas = explode("\n", $contenido);

        // Obtener los nombres de las columnas (primera fila)
        $columnNames = str_getcsv(array_shift($lineas));

        // Inicializar arreglos para almacenar datos
        $data = [];

        // Recorrer cada fila del CSV
        foreach ($lineas as $linea) {
            // Saltar filas vacías
            if (empty($linea)) continue;

            // Obtener datos de la fila actual
            $rowData = str_getcsv($linea);

            // Verificar si la fila tiene el mismo número de columnas que los nombres de columnas
            if (count($rowData) != count($columnNames)) {
                gg_response(400, json_encode(['error' => "El archivo CSV tiene un formato incorrecto."]));
            }

            // Crear un array asociativo con los nombres de columnas como claves y los valores de la fila
            $filaAsociativa = array_combine($columnNames, $rowData);

            // Ajustar el formato de los datos según sea necesario
            $filaAsociativa['Date'] = dateDMAtoSQL($filaAsociativa['Date']);
            $filaAsociativa['Time'] = hourAMto24($filaAsociativa['Time']);

            // Agregar la fila procesada al array de datos
            $data[] = $filaAsociativa;
        }

        // Ejemplo: Limpiar espacios en blanco de los valores
        foreach ($data as $key => $value) {
            $data[$key] = array_map('trim', $value);
        }

        $this->processCalls($data);
    }

    private function processCalls( $data ){
        $registrosSubidos = 0;
        $registrosDuplicados = 0;

        // Cargar los datos en lotes y actualizar en caso de duplicados
        if (!empty($data)) {
            $db = db_connect('production');
            $query = insertOnDuplicateUpdateBatch('llamadas_cio', $data, $this->arreglo);

            // gg_response(200, $query);
            $db->query($query);
            
            // Obtener la cantidad de registros subidos y omitidos por duplicidad
            $registrosSubidos = $db->affectedRows();
            $registrosDuplicados = count($data) - $registrosSubidos;
        }


        // Devolver la cantidad de registros subidos y omitidos por duplicidad
        $result = json_encode([
            'registros_subidos' => $registrosSubidos,
            'registros_omitidos' => $registrosDuplicados
        ]);

        gg_response(200, $result);
    }
}
