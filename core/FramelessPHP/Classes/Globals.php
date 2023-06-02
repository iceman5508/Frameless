<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0
 * Class Globals - This class handles the passing of persistent data between different php pages without
 * creating a session or cookie.
 * @package FramelessPHP\ibase
 */
class Globals
{

    protected static $globals;

    /**
     * Add a global to the list
     * @param globalName - The name the global will be stored as
     * @param globalVar - The value of the variable
     */
    public static function add($glabalName, $globalVar)
    {
        if(self::$globals !== null) {
            self::$globals[$glabalName] = $globalVar;
        }else {
            self::$globals = array();
            self::$globals[$glabalName] = $globalVar;
        }
    }

    /**
     * Get the value from a specific global
     * @param $globalName - the name of the global to return
     * @return the value associated with the global name
     */
    public static function get($globalName)
    {
        if(self::$globals == null) {
            return null;
        }else {
            return self::$globals[$globalName];
        }
    }

    /**
     * Remove a specific global from the list
     * @param $globalName - The name of the global to remove
     */
    public static function remove($globalName)
    {
        if(self::$globals !== null) {
            unset(self::$globals[$globalName]);
        }
    }

    /**
     * Returns a representation of all set globals
     *
     */
    public static function toString()
    {
        return json_decode(json_encode(self::$globals));
    }


}