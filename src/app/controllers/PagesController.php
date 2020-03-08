<?php

namespace EduCat\Controllers;

use EduCat\Core\Http\Controller;

class PagesController extends Controller
{
    public $app_name = "pages";

    public function index()
    {
        return $this->render('index');
    }
}
