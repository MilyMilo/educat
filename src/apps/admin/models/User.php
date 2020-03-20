<?php

namespace EduCat\Models;

use EduCat\Core\Models\Model;
use EduCat\Core\Contrib\Flash;

class User extends Model
{
    public static $allowed_types = ['ADMIN', 'TEACHER', 'STUDENT', 'EMPLOYEE'];

    public $db_id;
    public $db_username;
    public $db_first_name;
    public $db_last_name;
    public $db_email;
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
        $_SESSION["id"] = $user->id;
        $_SESSION["first_name"] = $user->first_name;
        $_SESSION["last_name"] = $user->last_name;
        $_SESSION["email"] = $user->email;
        $_SESSION["username"] = $user->username;
        $_SESSION["type"] = $user->type;
        return TRUE;
    }
    public function exists($key, $name)
    {
        $user = $this->select_where([$key => $name]);

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

    public static function ensure_authenticated()
    {
        if (!User::is_authenticated()) {
            return redirect('/login');
        }
    }


    public static function ensure_admin()
    {
        if (!User::is_authenticated()) {
            Flash::error("Please log-in first");
            return redirect('/login');
        }

        if (!User::is_admin()) {
            Flash::error("You are not permitted to access that page");
            return redirect('/');
        }
    }
}
