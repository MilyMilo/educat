<?php

namespace App\Models;

use App\Core\Models\Model;

class Metadata extends Model
{

    public $db_id;
    public $db__key;
    public $db__value;

    public static $defaults = [
        "title" => "Example title",
        "description" => "Example description",
        "keywords" => "this,is,example"
    ];

    public function exists($key)
    {
        $data = $this->select_where(["_key" => $key]);

        if (count($data) === 0) {
            return FALSE;
        }

        return TRUE;
    }

    public function create_default($key)
    {
        $this->create(["_key" => $key, "_value" => $this->defaults[$key]]);
    }
}
