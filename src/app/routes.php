<?php

$router->get('/^$/iA', 'PagesController@index');

$router->get('/^admin$/iA', 'AdminController@dashboard');

$router->get('/^login$/iA', 'UsersController@get_login');
$router->post('/^login$/iA', 'UsersController@post_login');

$router->get('/^register$/iA', 'UsersController@get_register');
$router->post('/^register$/iA', 'UsersController@post_register');

$router->get('/^logout$/iA', 'UsersController@get_logout');
