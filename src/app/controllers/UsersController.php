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
        $this->User = App::get('factory')->make('User');
    }

    public function post_register()
    {
        $data = [
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
            'type' => 'STUDENT',
        ];

        if ($this->User->exists($data['username'])) {
            Flash::error('This username is already taken.');
            return redirect('/register');
        }

        $this->User->register($data);
        return redirect('/login');
    }

    public function post_login()
    {
        $data = [
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
        ];

        if ($this->User->login($data)) {
            Flash::success('You have been logged in!');
            return redirect('/');
        }

        Flash::error('Invalid username and/or password!');
        return redirect('/login');
    }

    public function get_login()
    {
        if (User::is_authenticated()) {
            Flash::warning("You are already logged-in!");
            return redirect('/');
        }

        return view('login');
    }

    public function get_register()
    {
        if (User::is_authenticated()) {
            Flash::warning("You are already logged-in!");
            return redirect('/');
        }

        return view('register');
    }

    public function get_logout()
    {
        session_start();
        session_destroy();
        Flash::success("You have been successfully logged-out!");
        return redirect('/');
    }
}
