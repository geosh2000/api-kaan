<?php

function dbKeyFormat($texto) {
    // Reemplazar espacios por guiones bajos
    $texto = str_replace(' ', '_', $texto);
    
    // Convertir todo a minúsculas
    $texto = strtolower($texto);
    
    // Eliminar acentos
    $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
    $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
    $texto = strtr($texto, array_combine($acentos, $sin_acentos));
    
    // Eliminar caracteres que no sean números ni letras
    $texto = preg_replace('/[^a-z0-9_]/', '', $texto);
    
    return $texto;
}

function insertOnDuplicateUpdateBatch($table, $data, $map = array())
{
    $keys = array_keys($data[0]); // Obtener los nombres de las columnas
    $updateFields = [];
    $escapedKeys = [];
    foreach ($keys as $key) {
        $k = dbKeyFormat($key);
        if( count($map) ) {
            $k = $map[$k] ?? ($map[$key] ?? $k);
        }
        $updateFields[] = $k . '=VALUES(' . $k . ')';
        $escapedKeys[] = $k;
    }

    $valueStrings = [];
    foreach ($data as $row) {
        $values = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($row)); // Agregar comillas a los valores

        $valueStrings[] = '(' . implode(', ', $values) . ')';
    }

    return "INSERT INTO " . $table . " (" . implode(', ', $escapedKeys) . ") VALUES " . implode(', ', $valueStrings) . " ON DUPLICATE KEY UPDATE " . implode(', ', $updateFields);
}

function insertIgnoreBatch($table, $data, $map = array())
{
    $keys = array_keys($data[0]); // Obtener los nombres de las columnas
    $updateFields = [];
    $escapedKeys = [];
    foreach ($keys as $key) {
        $k = dbKeyFormat($key);
        if( count($map) ) {
            $k = $map[$k] ?? ($map[$key] ?? $k);
        }
        $updateFields[] = $k . '=VALUES(' . $k . ')';
        $escapedKeys[] = $k;
    }

    $valueStrings = [];
    foreach ($data as $row) {
        $values = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($row)); // Agregar comillas a los valores

        $valueStrings[] = '(' . implode(', ', $values) . ')';
    }

    return "INSERT IGNORE INTO " . $table . " (" . implode(', ', $escapedKeys) . ") VALUES " . implode(', ', $valueStrings);
}

