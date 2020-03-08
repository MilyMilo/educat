<?php

namespace EduCat\Core\Templating;

class Renderer
{
    protected static $context_processors = [];
    protected static $static_context = [];
    protected $template_dir;

    public function __construct($template_dir, $static_context = [])
    {
        $this->template_dir = $template_dir;
        $this->static_context = $static_context;
    }

    public static function use(ContextProcessor ...$cps)
    {
        array_push(Renderer::$context_processors, ...$cps);
    }

    public static function inherit($file)
    {
        $renderer = new static('');
        extract(array_merge($renderer->_build_dynamic_context(), $renderer->static_context));
        return include_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/' . trim($file, "/") . ".php");
    }

    public static function partial($file)
    {
        $renderer = new static('');
        extract(array_merge($renderer->_build_dynamic_context(), $renderer->static_context));
        return include_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/partials/' . trim($file, "/") . ".php");
    }

    public static function static_render($file, $data = [])
    {
        $renderer = new static('');
        extract(array_merge($renderer->_build_dynamic_context(), $renderer->static_context, $data));
        return require($_SERVER['DOCUMENT_ROOT'] . '/app/views/' . trim($file, "/") . ".view.php");
    }

    public function render($name, $data = [])
    {
        extract(array_merge($this->_build_dynamic_context(), $this->static_context, $data));
        return require($_SERVER['DOCUMENT_ROOT'] . "/" . trim($this->template_dir, "/") . "/{$name}.view.php");
    }

    private function _build_dynamic_context()
    {
        $context = [];

        if (is_array(Renderer::$context_processors)) {
            foreach (Renderer::$context_processors as $i => $processor) {
                foreach ($processor->get_context() as $name => $value) {
                    $context[$name] = $value;
                }
            }
        }

        return $context;
    }
}
