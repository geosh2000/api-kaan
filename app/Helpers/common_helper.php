<?php

    function gg_response( $code, $data = [], $type = 'json' ){

        $response = \Config\Services::response();

        $response->setStatusCode($code);

        switch( $type ){
            case 'json':
                $response->setJSON($data);
                break;
            case 'xml':
                $response->setXML($data);
                break;
            case 'html':
                $response->setBody($data);
                break;
            default:    
                $response->setBody($data);
                break;
        }

        $response->send();
        die();

    }

    function gg_die( $msg ){
        $response = \Config\Services::response();

        $response->setStatusCode(401)->setJson(array("msg" => $msg))->send();
        die();
    }

    function ifEmpty( $data, $msg = null ){

        if( $msg == null ){
            $msg = "No se encontraron registros";
        }

        if( empty($data) ){
            $json = array(
                "msg" => $msg
            );
            gg_response(400, $json);
        }

    }


    function dateDMAtoSQL($fecha) {
        // Divide la fecha en día, mes y año
        $partes = explode('/', $fecha);
        
        // Verifica si hay tres partes y si son números válidos
        if(count($partes) == 3 && is_numeric($partes[0]) && is_numeric($partes[1]) && is_numeric($partes[2])) {
            // Convierte el año a formato de 4 dígitos
            $año = (int)$partes[2];
            if($año < 100) {
                // Si el año es menor que 100, se asume que está en formato de dos dígitos
                // y se convierte a formato de cuatro dígitos según el contexto
                $año += ($año < 70) ? 2000 : 1900;
            }
            
            // Formatea la fecha en el formato deseado
            $fecha_formateada = sprintf("%04d-%02d-%02d", $año, $partes[1], $partes[0]);
            
            return $fecha_formateada;
        } else {
            // Si la fecha no está en el formato esperado, devuelve null o lanza una excepción según lo prefieras
            // Aquí devolvemos null en caso de error
            return null;
        }
    }

    function hourAMto24($hora) {
        // Convierte la hora al formato de 24 horas
        $hora_formateada = date("H:i:s", strtotime($hora));
        
        return $hora_formateada;
    }

    function longDateFormat( $fecha, $idioma = 'Eng' ){

            $idioma = $idioma != 'Esp' ? 'Eng' : 'Esp';
            $fmtLang = $idioma == 'Eng' ? 'en_US' : 'es_ES';

            // Separar la fecha en partes
            $partes_fecha = explode('/', str_replace("-", "/", $fecha));
            
            // Obtener el día, mes y año
            $año = $partes_fecha[0];
            $mes = $partes_fecha[1];
            $dia = $partes_fecha[2];
            
            // Crear objeto de fecha
            $fecha_objeto = mktime(0, 0, 0, $mes, $dia, $año);
            
            // Obtener fecha formateada en idioma elegido
            $fmt = new IntlDateFormatter($fmtLang, IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $fecha_formateada = $fmt->format($fecha_objeto);
            
         
            
            return $fecha_formateada;
    }

    function moneyFormat($monto) {
        $monto = floatval($monto);
        return number_format($monto, 2, '.', ',');
    }

    function cleanTrim( $texto ){
        return preg_replace('/[^\p{L}\p{N}_]/u', '', $texto);
    }

    function permiso( $p ){
        $session = session();
        $perm = $session->get('permissions');
        $jsonData = base64_decode($perm);
        $permisos = json_decode($jsonData, true);

    //    return in_array($p, $permisos);
    return true;
    }


?>


