<?php

$router->get('admin', '/^admin$/iA', 'AdminController@dashboard');
$router->get('admin', '/^admin\/users$/iA', 'AdminController@get_users');
$router->get('admin', '/^admin\/users\/create$/iA', 'AdminController@create_user_form');
$router->get('admin', '/^admin\/users\/(?P<id>[-\w]+)$/iA', 'AdminController@user_details');
$router->get('admin', '/^admin\/users\/(?P<id>[-\w]+)\/update$/iA', 'AdminController@update_user_form');
$router->get('admin', '/^admin\/users\/(?P<id>[-\w]+)\/delete$/iA', 'AdminController@delete_user_form');
$router->post('admin', '/^admin\/users\/create$/iA', 'AdminController@create_user');
$router->post('admin', '/^admin\/users\/(?P<id>[-\w]+)\/update$/iA', 'AdminController@update_user');
$router->post('admin', '/^admin\/users\/(?P<id>[-\w]+)\/delete$/iA', 'AdminController@delete_user');

$router->get('admin', '/^admin\/settings$/iA', 'SettingsController@index');
$router->post('admin', '/^admin\/settings$/iA', 'SettingsController@get_post_data');

$router->get('admin', '/^login$/iA', 'UsersController@get_login');
$router->post('admin', '/^login$/iA', 'UsersController@post_login');
$router->get('admin', '/^register$/iA', 'UsersController@get_register');
$router->post('admin', '/^register$/iA', 'UsersController@post_register');
$router->get('admin', '/^logout$/iA', 'UsersController@get_logout');
