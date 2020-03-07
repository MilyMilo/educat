<?php

$router->get('/^$/iA', 'PagesController@index');

$router->get('/^admin$/iA', 'AdminController@dashboard');
$router->get('/^admin\/users$/iA', 'AdminController@get_users');

$router->get('/^admin\/users\/create$/iA', 'AdminController@create_user_form');
$router->get('/^admin\/users\/(?P<id>[-\w]+)$/iA', 'AdminController@user_details');
$router->get('/^admin\/users\/(?P<id>[-\w]+)\/update$/iA', 'AdminController@update_user_form');
$router->get('/^admin\/users\/(?P<id>[-\w]+)\/delete$/iA', 'AdminController@delete_user_form');

$router->post('/^admin\/users\/create$/iA', 'AdminController@create_user');
$router->post('/^admin\/users\/(?P<id>[-\w]+)\/update$/iA', 'AdminController@update_user');
$router->post('/^admin\/users\/(?P<id>[-\w]+)\/delete$/iA', 'AdminController@delete_user');

$router->get('/^admin\/settings$/iA', 'SettingsController@index');
$router->post('/^admin\/settings$/iA', 'SettingsController@get_post_data');

$router->get('/^login$/iA', 'UsersController@get_login');
$router->post('/^login$/iA', 'UsersController@post_login');

$router->get('/^register$/iA', 'UsersController@get_register');
$router->post('/^register$/iA', 'UsersController@post_register');

$router->get('/^logout$/iA', 'UsersController@get_logout');
