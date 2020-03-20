<?php

require('../vendor/autoload.php');

use EduCat\Core\App;
use EduCat\Core\Database\{
    Connection,
    MigrationRunner
};

App::bind('config', require('../config.php'));

$migrator = new MigrationRunner(Connection::make(App::get('config')['database']));

$migrator->run("
    CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        type ENUM('ADMIN', 'STUDENT', 'TEACHER', 'EMPLOYEE') NOT NULL
    );
");
$migrator->run("
    CREATE TABLE IF NOT EXISTS recovery_tokens (
        id INT PRIMARY KEY AUTO_INCREMENT,
        uid VARCHAR(255),
        token VARCHAR(255) NOT NULL UNIQUE
    );
");

$migrator->run("
    CREATE TABLE IF NOT EXISTS permissions (
        id int(11) NOT NULL,
        name text NOT NULL,
        description text NOT NULL
    );
");

$migrator->run("
    CREATE TABLE IF NOT EXISTS metadatas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        _key TEXT NOT NULL,
        _value TEXT NOT NULL
    );
");

$migrator->run("
    CREATE TABLE IF NOT EXISTS contacts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        _key TEXT NOT NULL,
        _value TEXT NOT NULL
    );
");
