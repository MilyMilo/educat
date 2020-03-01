<?php

namespace App\Models;

use App\Core\Models\Model;

class News extends Model
{
    public $db_id;
    public $db_title;
    public $db_content;
    public $db_is_published;
}
