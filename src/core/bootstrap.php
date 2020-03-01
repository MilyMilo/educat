<?php

use App\Core\App;
use App\Core\Database\{
    Connection
};

use App\Core\Models\ModelFactory;

App::bind('config', require('config.php'));

App::bind('factory', new ModelFactory(
    Connection::make(App::get('config')['database'])
));

session_name(App::get('config')['session_name']);

require_once('utils.php');
