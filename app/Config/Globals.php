<?php

namespace Config;

class Globals
{
    public static $jwtKey = 'adh_grp_geoshGlobal';

    public static $templates = ENVIRONMENT === 'development' ? 'http://localhost:8888/adhApi/public/html/mailing/' : 'https://atelier-cc.azurewebsites.net/public/html/mailing/';
    public static $public = ENVIRONMENT === 'development' ? 'http://localhost:8888/adhApi/public/' : 'https://atelier-cc.azurewebsites.net/public/';
    public static $assets = ENVIRONMENT === 'development' ? 'http://localhost:8888/adhApi/public/assets/' : 'https://glassboardengine.azurewebsites.net/assets/';

    public function __construct()
    {

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'development') {
            $this->templates = 'http://localhost:8888/adhApi/public/html/mailing/';
        }
    }
}
