<?php

namespace EduCat\Controllers\Pages;

use EduCat\Core\Http\Controller;

class PagesController extends Controller
{
    public function index()
    {
        return $this->render('index');
    }
}
