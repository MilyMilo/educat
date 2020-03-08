<?php

namespace EduCat\Core\Http;

use EduCat\Core\Templating\Renderer;

abstract class Controller
{
    public $app_name;

    public function __construct()
    {
        if (!$this->app_name) {
            throw new \Exception("Classes extending Controller need to define \$app_name.");
        }
    }

    public function render($view, $data = [])
    {
        $renderer = new Renderer("app/views/$this->app_name");
        return $renderer->render($view, $data);
    }
}
