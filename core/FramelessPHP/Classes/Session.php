<?php


namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class Session - This class handle session related functions.
 * @package FramelessPHP\ibase
 */
class Session
{

    /**
     * Check if a specific session name exists
     */
    public static function exists($name){

        return (isset($_SESSION[$name])? true: false);

    }

    /**
     * set a session
     * @param $name - the name of the session
     * @param $value - the value of the session
     */
    public static function set($name, $value){
        $_SESSION[$name] = $value;
    }

    /**
     *Get a session by name
     * @param $name - the name of the session
     * @return the value of the session
     */
    public static function get($name){
        return $_SESSION[$name];

    }

    /**
    *delete a session
     * @param $name - The name of the session to remove
     */
    public static function delete($name){
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Flash a session the delete it
     * @param $name - the name of the session
     * @param string $string - the value to flash
     * @return the session to flash
     */
    public static function flash($name, $string = ' '){
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::set($name , $string);
        }
    }

}