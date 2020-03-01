<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\{
    App,
    Contrib\Flash,
    Routing\Request
};

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
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
            'type' => 'USER',
        ];

        if ($User->exists($data['username'])) {
            Flash::error('This username is already taken.');
            return redirect('/register');
        }

        $User->register($data);
        return redirect('/login');
    }

    public function post_login()
    {
        $User = $this->models['User'];
        $data = [
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
        ];

        $User->login($data);
        return redirect('/');
    }

    public function get_login()
    {
        if (User::is_authenticated()) {
            return redirect('/admin');
        }

        return view('login');
    }

    public function get_register()
    {
        if (User::is_authenticated()) {
            return redirect('/admin');
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
