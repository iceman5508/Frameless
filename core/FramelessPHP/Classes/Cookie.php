<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class Cookie -  This class handles the crud actions of cookies.
 * @package FramelessPHP\ibase
 */

class Cookie
{
    /**
     * Check if a specific cookie name exists
     */
    public static function exists($name){
        return (isset($_COOKIE[$name])? true: false);

    }

    /**
     * set a cookie
     * @param $name - the name of the cookie
     * @param $value - the value of the cookie
     * @param $time - When should the cookie expire - Null by default
     */
    public static function set($name, $value, $time = NULL) {
       if($time != NULL) {
        setcookie($name, $value, $time);
       }else
           setcookie($name, $value);
    }

    /**
     *Get a cookie by name
     * @param $name - the name of the cookie
     * @return the value of the cookie
     */
    public static function get($name){
        return $_COOKIE[$name];

    }

    /**
     *delete a cookie
     * @param $name - The name of the cookie to remove
     */
    public static function delete($name){
        if(self::exists($name)) {
            unset($_COOKIE[$name]);
            setcookie($name, null, -1);
        }
    }



}