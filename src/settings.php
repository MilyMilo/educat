<?php

use EduCat\Core\App;
use EduCat\Core\Database\{
    Connection
};
use EduCat\Core\Models\ModelFactory;

App::bind('config', require('config.php'));

App::bind('factory', new ModelFactory(
    Connection::make(App::get('config')['database'])
));

App::bind('apps', [
    'admin',
    'pages'
]);

App::bind(
    'context_processors',
    [
        'UserContextProcessor',
        'MetadataContextProcessor',
        'PathContextProcessor',
    ]
);
