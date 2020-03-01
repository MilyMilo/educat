<?php

$router->get('', 'PagesController@index');

$router->get('dashboard', 'AdminController@dashboard');

$router->get('login', 'UsersController@get_login');
$router->post('login', 'UsersController@post_login');

$router->get('register', 'UsersController@get_register');
$router->post('register', 'UsersController@post_register');

$router->get('logout', 'UsersController@get_logout');
