<?php

namespace EduCat\Controllers\Admin;

use EduCat\Models\User;
use EduCat\Core\{
    App,
    Contrib\Flash,
    Http\Request
};
use EduCat\Core\Http\Controller;

class UsersController extends Controller
{
    public function init()
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
        Flash::success('User has been successfully created! You can now log in.');
        return redirect('/login');
    }

    public function post_login()
    {
        $data = [
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
        ];

        if ($this->User->login($data)) {
            $user = $this->User->select_one_where(['username' => $data['username']]);
            if ($user->type === "ADMIN") {
                return redirect('/admin');
            }
            return redirect('/');
        }

        Flash::error('Invalid username and/or password!');
        return redirect('/login');
    }

    public function get_login()
    {
        if (User::is_authenticated()) {
            Flash::warning('You are already logged-in!');
            return redirect('/');
        }

        return $this->render('users/login');
    }

    public function get_register()
    {
        if (User::is_authenticated()) {
            Flash::warning("You are already logged-in!");
            return redirect('/');
        }

        return $this->render('users/register');
    }

    public function get_logout()
    {
        session_start();
        session_destroy();
        Flash::success("You have been successfully logged-out!");
        return redirect('/');
    }
}
