<?php

use App\Core\{
    Request,
    Router
};

require('vendor/autoload.php');
require('vendor/ti.php');
require('core/bootstrap.php');

Router::load('app/routes.php')->direct(Request::uri(), Request::method());
