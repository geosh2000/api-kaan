<?php namespace App\Libraries\Adh;

class AdhApi {

    public function getFromF2go($rsva, $hotel = "ATPM") {
        // La URL del endpoint
        $url = "https://prod-47.eastus.logic.azure.com:443/workflows/4b9ada93c57d4ff99b180251049d8bd5/triggers/PMSDetails/paths/invoke?api-version=2016-10-01&sp=%2Ftriggers%2FPMSDetails%2Frun&sv=1.0&sig=-u_mGlDTtrLI8Pl_wJ2HqMd4uci79T_tgV_vzLt3NyM";

        // El cuerpo de la solicitud en formato JSON
        $data = json_encode([
            "prop_code" => $hotel,
            "rsrv_code" => $rsva
        ]);

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura cURL para una solicitud POST
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Ejecuta la solicitud y obtiene la respuesta
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);

        // Cierra la sesión de cURL
        curl_close($ch);

        // Define la estructura de la respuesta
        $result = [
            'err' => false,
            'msg' => 'Reserva obtenida',
            'response' => $httpcode,
            'data' => json_decode($response, true)
        ];

        // Manejo de errores
        if ($response === false || $httpcode != 200) {
            $result['err'] = true;
            $result['msg'] = 'Error en la solicitud: ' . $curl_error;
            $result['data'] = null;
        }

        // Retorna la respuesta como JSON
        return $result;
    }
}
