<?php

namespace Config;

class Globals
{
    public static $jwtKey = 'adh_grp_geoshGlobal';

    public static $templates = 'https://atelier-cc.azurewebsites.net/public/html/mailing/';

    public function __construct()
    {

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'development') {
            $this->templates = 'http://localhost:8888/adh/frames/templates/mailing/';
        }
    }
}
