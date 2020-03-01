<?php

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    protected $models = [];

    public function __construct()
    {
        $this->models['User'] = App::get('factory')->make('User');
    }

    public function post_register()
    {
        $User = $this->models['User'];

        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'type' => 'USER',
        ];

        if ($User->exists($data['username'])) {
            // TODO: Some sort of flash message
        }

        $User->register($data);
        return redirect('/login');
    }

    public function post_login()
    {
        $User = $this->models['User'];
        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
        ];

        $User->login($data);
        return redirect('/');
    }

    public function get_login()
    {
        $User = $this->models['User'];

        if ($User::is_authenticated()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function get_register()
    {
        $User = $this->models['User'];

        if ($User::is_authenticated()) {
            return redirect('/dashboard');
        }

        return view('register');
    }

    public function get_logout()
    {
        session_start();
        session_destroy();
        return redirect('/');
    }
}
