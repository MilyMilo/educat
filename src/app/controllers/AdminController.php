<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\User;

class AdminController
{
    protected $models = [];

    public function __construct()
    {
        $this->models['User'] = App::get('factory')->make('User');
    }

    public function dashboard()
    {
        User::ensure_authenticated();
        return view('dashboard');
    }
}
