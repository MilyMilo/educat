<?php

namespace EduCat\Core\Contrib;

/**
 * Flash provides simple flash messaging system.
 * Messages are saved in session and popped next time they are accessed. 
 */
class Flash
{
    /**
     * error_classes are a mapping between logical status levels (such as error or warning)
     * and framework specific css class names (such as danger)
     */
    public static $error_classes = [
        "error" => "danger",
        "warning" => "warning",
        "success" => "success",
        "info" => "info",
    ];

    public static function error($message)
    {
        Flash::flash('error', $message);
    }

    public static function warning($message)
    {
        Flash::flash('warning', $message);
    }

    public static function success($message)
    {
        Flash::flash('success', $message);
    }

    public static function info($message)
    {
        Flash::flash('info', $message);
    }

    public static function get()
    {
        $flashes = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flashes;
    }

    public static function flash($level, $message)
    {
        $new_flash = ["level" => Flash::$error_classes[$level], "message" => $message];
        $_SESSION["flash"][] = $new_flash;
    }
}
