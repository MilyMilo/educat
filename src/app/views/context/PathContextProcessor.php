<?php

namespace EduCat\Views;

use EduCat\Core\Http\Request;
use EduCat\Core\Templating\ContextProcessor;

class PathContextProcessor implements ContextProcessor
{
    public function get_context()
    {
        $path = Request::uri();
        return [
            "path" => $path,
        ];
    }
}
