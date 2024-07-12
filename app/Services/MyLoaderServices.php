<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Config;
use CodeIgniter\Services;

class MyLoaderService
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function loadDatabase($params = null, $return = false, $activeRecord = null)
    {
        // Check if the database service is already loaded
        if ($this->app->has('db') && !$return && $activeRecord === null) {
            return false;
        }

        // Load the base DB class
        $dbConfig = new Config();

        // Load the custom DB driver if it exists
        $customDBDriver = $dbConfig->subclassPrefix . 'DB_' . $dbConfig->defaultDriver . '_driver';
        $customDBDriverClass = 'App\\Libraries\\Database\\' . $customDBDriver;

        if (class_exists($customDBDriverClass)) {
            $dbConfig->swapDriver($customDBDriver);
        }

        // Load the database service with the custom configuration
        $db = Services::database($params, $return, $activeRecord);
        $this->app->instance('db', $db);

        return $db;
    }
}
