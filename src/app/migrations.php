<?php

require('../vendor/autoload.php');

use App\Core\App;
use App\Core\Database\{
    Connection,
    MigrationRunner
};

App::bind('config', require('../config.php'));

$migrator = new MigrationRunner(Connection::make(App::get('config')['database']));

$migrator->run("
    CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        type ENUM('ADMIN', 'STUDENT', 'TEACHER', 'EMPLOYEE') NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS metadatas(
        id INT PRIMARY KEY AUTO_INCREMENT,
        _key TEXT NOT NULL,
        _value TEXT NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS contacts(
        id INT PRIMARY KEY AUTO_INCREMENT,
        _key TEXT NOT NULL,
        _value TEXT NOT NULL
    );
");
