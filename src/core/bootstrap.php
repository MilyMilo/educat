<?php

use EduCat\Core\App;
use EduCat\Core\Templating\Renderer;

require_once('utils.php');

foreach (App::get('context_processors') as $cp) {
    $context_processor = "EduCat\\Views\\$cp";
    $context_processor = new $context_processor();
    Renderer::use($context_processor);
}

session_name(App::get('config')['session_name']);
session_start();
