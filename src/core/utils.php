<?php

/**
 * Include a partial
 * Use this is template to include for example from flash.php
 * 
 * @param string $file path to file relative to partials directory 
 */
function partial($file)
{
    return include($_SERVER['DOCUMENT_ROOT'] . '/app/views/partials/' . $file . '.php');
}

/**
 * Inherit from view
 * Use this is template to inherit for example from base.php
 * 
 * @param string $file path to file relative to views directory 
 */
function inherit($file)
{
    return include($_SERVER['DOCUMENT_ROOT'] . '/app/views/' . $file);
}

/**
 * Render view
 * 
 * @param string $name View to render (without path and suffix)
 * @param mixed[] $data Data to be passed to the view
 * @return void
 */
function view($name, $data = [])
{
    extract($data);
    return require("app/views/{$name}.view.php");
}

/**
 * Returns HTTP redirection header
 * 
 * @param string $url Full url to redirect to
 * @param bool $permanent (optional) true if redirect should be permanent (default false)
 * @return void
 */
function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

/**
 * Check if $str starts with $prefix
 * 
 * @param string $str String to check if has $prefix
 * @param string $prefix String to look for in $str
 * @return bool TRUE is $str starts with $prefix, else FALSE
 */

function has_prefix($str, $prefix)
{
    if (strpos($str, $prefix) === 0) {
        return TRUE;
    }

    return FALSE;
}

/**
 * Strip from left side of the string
 * 
 * @param string $str String have prefix removed
 * @param string $prefix String to remove from base
 * @return string $str Without $prefix on the left side 
 */
function strip_prefix($str, $prefix)
{
    if (substr($str, 0, strlen($prefix)) == $prefix) {
        $str = substr($str, strlen($prefix));
    }

    return $str;
}

/**
 * Dump variables and die
 * 
 * @param mixed $values Objects to dump
 * @return void
 */
function dd(...$values)
{
    echo "<pre>";
    print_r($values);
    echo "</pre>";
    die();
}

/**
 * Generate clean backtrace
 * 
 * @param \Exception $e Exception to generate call tree off
 * @return string Generated call tree
 */
function generate_call_tree($e)
{
    $trace = explode("\n", $e->getTraceAsString());
    $trace = array_reverse($trace);
    array_shift($trace);
    array_pop($trace);
    $length = count($trace);
    $result = array();

    for ($i = 0; $i < $length; $i++) {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' '));
    }

    return "" . implode("\n", $result);
}

/**
 * Pluralizes a word if quantity is not one.
 *
 * @param int $quantity Number of items
 * @param string $singular Singular form of word
 * @param string $plural Plural form of word; function will attempt to deduce plural form from singular if not provided
 * @return string Pluralized word if quantity is not one, otherwise singular
 * 
 * https://stackoverflow.com/questions/1534127/pluralize-in-php
 */
function pluralize($quantity, $singular, $plural = null)
{
    if ($quantity == 1 || !strlen($singular)) return $singular;
    if ($plural !== null) return $plural;

    $last_letter = strtolower($singular[strlen($singular) - 1]);
    switch ($last_letter) {
        case 'y':
            return substr($singular, 0, -1) . 'ies';
        case 's':
            return $singular;
        default:
            return $singular . 's';
    }
}

/**
 * Generate SQL table name off $input
 * Changes pascal case strings to snake case
 * 
 * Example:
 * sqlify("UserProfile") -> user_profiles
 * 
 * @param string $input 
 * @return string Sqlified string
 */
function sqlify($input)
{
    return pluralize(2, ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_'));
}
