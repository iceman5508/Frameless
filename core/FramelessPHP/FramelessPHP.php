<?php
/**
@version 1.0 Beta
 * <br>
 * This class is the entry point
 * for the data engine.
 * Documentation in this file is limited since there is very little to no
 * interaction with this file at all.
 */



class FramelessPHP {
    private static $instance = NULL;

    private function __clone(){}

    private function __wakeup(){}

    public static function dirHome()
    {
        //return 	getcwd().'/';
        return CORE.'/FramelessPHP/';
    }

    /**
     * Get the current instance of the Engine
     */
    public static function getInstance(){
        if(!isset(self::$instance)) {
            self::$instance = new FramelessPHP();
        }
        return self::$instance;
    }

    public function loadFunctions(){
        $dir =  self::dirHome().'Functions';
        foreach(glob($dir.'/*.php') as $function)
        {
            require_once($function);
        }
    }

    private function __construct() {
        $this->loadFunctions();
    }

    function __destruct() {}

}


FramelessPHP::getInstance();