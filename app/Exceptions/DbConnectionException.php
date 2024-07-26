<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\FrameworkException;

class DbConnectionException extends FrameworkException
{
    public static function forDatabaseConnection()
    {
        return new static('Error al conectar a la base de datos.');
    }
}
