<?php

namespace Config;

class Globals
{
    public static $jwtKey = 'gg_geoshGlobal_zendesk';

    public static $templates = ENVIRONMENT === 'development' ? 'http://localhost:8888/marketplace/geoshGlobal/public/html/mailing/' : 'https://zd.geoshglobal.com/public/html/mailing/';
    public static $public = ENVIRONMENT === 'development' ? 'http://localhost:8888/marketplace/geoshGlobal/public/' : 'https://zd.geoshglobal.com/public/';
    public static $assets = ENVIRONMENT === 'development' ? 'http://localhost:8888/marketplace/geoshGlobal/public/assets/' : 'https://zd.geoshglobal.com/public/assets/';

    public function __construct()
    {

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'development') {
            $this->templates = 'http://localhost:8888/marketplace/public/html/mailing/';
        }
    }
}
