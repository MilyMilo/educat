<?php

require_once('utils.php');

use EduCat\Core\App;
use EduCat\Core\Database\{
    Connection
};
use EduCat\Core\Models\ModelFactory;
use EduCat\Core\Templating\Renderer;
use EduCat\Views\{UserContextProcessor, MetadataContextProcessor, PathContextProcessor};

App::bind('config', require('config.php'));

App::bind('factory', new ModelFactory(
    Connection::make(App::get('config')['database'])
));

// Installed Context Processors
Renderer::use(
    new UserContextProcessor(),
    new MetadataContextProcessor(),
    new PathContextProcessor(),
);

session_name(App::get('config')['session_name']);
session_start();
