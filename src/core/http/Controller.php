<?php

namespace EduCat\Core\Http;

use EduCat\Core\Templating\Renderer;

abstract class Controller
{
    public $app_name;

    public function __construct($app_name)
    {
        $this->app_name = $app_name;
        $this->init();
    }

    public function render($view, $data = [])
    {
        $renderer = new Renderer("apps/$this->app_name/views");
        return $renderer->render($view, $data);
    }

    protected function init()
    {
        return; // Stub definition to satisfy linter
    }
}
