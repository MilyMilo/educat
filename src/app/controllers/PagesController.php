<?php

namespace App\Controllers;

use App\Core\App;

class PagesController
{

    public function __construct()
    {
        $this->models['News'] = App::get('factory')->make('News');
        $this->models['User'] = App::get('factory')->make('User');
    }

    public function index()
    {
        return view('index');
    }
}
