<?php

return [
    "database" => [
        "name" => "educat",
        "username" => "root",
        "password" => "password",
        "connection" => "mysql:host=db",
        "options" => []
    ],
    "smtp" => [
        "host" => "smtp.gmail.com",
        "SMTPAuth" => TRUE,
        "username" => "helpdesk.educat@gmail.com",
        "password" => "SKiwHYeVpX3mkYq",
        "SMTPSecure" => 'PHPMailer::ENCRYPTION_STARTTLS',
        "port" => "587"
    ],
    "debug" => TRUE,
    "session_name" => "educat_session"
];
