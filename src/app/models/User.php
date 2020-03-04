<?php

namespace App\Models;

use App\Core\Models\Model;

class User extends Model
{
    public static $allowed_types = ['ADMIN', 'USER'];

    public $db_id;
    public $db_username;
    public $db_password;
    public $db_type;

    public function register($data)
    {
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['password'] = $password;
        $this->create($data);
    }

    public function login($data)
    {
        $user = $this->select_where(["username" => $data["username"]])[0];

        if (!password_verify($data["password"], $user->password)) {
            return FALSE;
        }

        session_start();
        $_SESSION["username"] = $user->username;
        $_SESSION["type"] = $user->type;
        return TRUE;
    }

    public function exists($username)
    {
        $user = $this->select_where(["username" => $username]);

        if (count($user) === 0) {
            return FALSE;
        }

        return TRUE;
    }

    public static function is_authenticated()
    {
        session_start();
        if (array_key_exists('username', $_SESSION) && !empty($_SESSION['username'])) {
            return TRUE;
        }

        return FALSE;
    }

    public static function is_admin()
    {
        session_start();
        if (array_key_exists('type', $_SESSION) && !empty($_SESSION['type']) && $_SESSION['type'] == 'ADMIN') {
            return TRUE;
        }

        return FALSE;
    }

    public static function ensure_authenticated($redirect_url = '/login')
    {
        if (!User::is_authenticated()) {
            return redirect($redirect_url);
        }
    }
}
