<?php

namespace EduCat\Views;

use EduCat\Core\App;
use EduCat\Core\Templating\ContextProcessor;

use EduCat\Models\Metadata;

class MetadataContextProcessor implements ContextProcessor
{
    private Metadata $Metadata;

    public function __construct()
    {
        $this->Metadata = App::get('factory')->make('Metadata');
    }

    public function get_context()
    {
        $title = $this->Metadata->select_one_where(["_key" => "title"])->_value;
        $description = $this->Metadata->select_one_where(["_key" => "description"])->_value;
        $keywords = $this->Metadata->select_one_where(["_key" => "keywords"])->_value;

        return [
            "title" => $title,
            "description" => $description,
            "keywords" => $keywords,
        ];
    }
}
