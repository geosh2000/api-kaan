<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CsvUpload extends Controller
{
    public function upload()
    {
        helper(['form', 'url']);

        // Cargar el modelo
        $llamadasModel = new \App\Models\LlamadasModel();

        // Procesar el archivo CSV
        if ($this->request->getMethod() === 'post') {
            $csv = $this->request->getFile('csv_file');

            // Leer el archivo CSV
            $csvData = array_map('str_getcsv', file($csv->getTempName()));

            $index = 0;

            // Insertar datos en la base de datos
            foreach ($csvData as $row) {
                if( $index == 0 ) {
                    $index++;
                    continue;
                }else{
                    $index++;
                }

                $llamadasModel->insert([
                    // 'Fecha' => date('Y-m-d', strtotime($row[0])), // Suponiendo que la fecha está en la primera columna
                    // 'Hora' => date('H:i:s', strtotime($row[1])), // Suponiendo que la hora está en la segunda columna
                    'Date' => $row[0], // Ajusta los índices según la estructura de tu CSV
                    'Queue' => $row[1], // Ajusta los índices según la estructura de tu CSV
                    'Agent' => $row[2],
                    'Number' => $row[3],
                    'Event' => $row[4],
                    'WaitTime' => $row[5],
                    'TalkTime' => $row[6],
                    'uniqueid' => $row[7]
                ]);

            }

            // Redirigir a la página de inicio o mostrar un mensaje de éxito
            return redirect()->to('/');
        } else {
            // Mostrar la vista de carga del archivo
            return view('upload_csv');
        }
    }
}
