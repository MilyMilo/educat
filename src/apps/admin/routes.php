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
$router->get('admin', '/^logout$/iA', 'UsersController@get_logout');

$router->get('admin', '/^password_reset$/iA', 'UsersController@get_password_reset');
$router->get('admin', '/^password_reset\/(?P<id>[-\w]+)\/(?P<token>[-\w]+)$/iA', 'UsersController@get_new_password');
$router->post('admin', '/^password_reset\/(?P<id>[-\w]+)\/(?P<token>[-\w]+)$/iA', 'UsersController@post_new_password');

$router->get('admin', '/^pending$/iA', 'UsersController@get_pending');
$router->post('admin', '/^pending$/iA', 'UsersController@post_pending');

$router->get('admin', '/^profile$/iA', 'UsersController@get_index');
$router->get('admin', '/^profile\/update$/iA', 'UsersController@get_edit');
$router->post('admin', '/^profile\/update$/iA', 'UsersController@update_user');
