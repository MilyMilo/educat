<?php

namespace EduCat\Views;

use EduCat\Models\User;
use EduCat\Core\Templating\ContextProcessor;

class UserContextProcessor implements ContextProcessor
{
    public function get_context()
    {
        if (!User::is_authenticated()) {
            return [
                "user" => NULL,
            ];
        }

        $user = new \stdClass;
        $user->username = $_SESSION['username'];
        $user->type = $_SESSION['type'];

        return [
            "user" => $user,
        ];
    }
}
