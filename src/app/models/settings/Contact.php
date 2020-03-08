<?php

namespace EduCat\Models;

use EduCat\Core\Models\Model;

class Contact extends Model
{

    public $db_id;
    public $db__key;
    public $db__value;

    public static $defaults = [
        "school_name" => "My school",
        "address" => "ul. Mazowiecka 13",
        "city" => "Szczecin",
        "postal_code" => "70-526",
        "phone_number" => "91 488 47 37"
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
        $this->create(["_key" => $key, "_value" => Contact::$defaults[$key]]);
    }
}
