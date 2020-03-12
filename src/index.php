<?php

use EduCat\Core\Http\{
    Request,
    Router
};

require('vendor/autoload.php');
require('vendor/ti.php');
require('settings.php');
require('core/bootstrap.php');

Router::load()->direct(Request::uri(), Request::method());
