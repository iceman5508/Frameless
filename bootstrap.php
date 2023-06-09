<?php
/**
 * The bootstrap file for loading files
 * This file needs to be included in files that are going to use
 * the framework.
 */

define('BASEPATH', __DIR__);
define('CORE', BASEPATH.'/core');

//include FramelessPHP Library
require_once 'core/FramelessPHP/FramelessPHP.php';

//include libloader library
require_once 'core/libloader/LibLoader.php';

//load in API classes
require_once 'core/API/FramelessApi.php';




    /**
     * Auto load classes as needed
     * @param $classname - the class name
     * @throws Exception
     */
if(!function_exists('classAutoLoader')){
    function classAutoLoader($classname){
        $parts = explode('\\', $classname);
        $classname = end($parts);

        if(file_exists(CORE.'/FramelessPHP/Classes/'.basename($classname).'.php')){
            require_once CORE.'/FramelessPHP/Classes/'.basename($classname).'.php';
        }else if(file_exists(CORE.'/FramelessPHP/Classes/iExtensions/'.basename($classname).'.php')){
            require_once CORE.'/FramelessPHP/Classes/iExtensions/'.basename($classname).'.php';
        }
        else if(file_exists(CORE.'/libloader/Classes/'.basename($classname).'.php')){
            require_once CORE.'/libloader/Classes/'.basename($classname).'.php';
        }else if(file_exists(CORE.'/libloader/Classes/iExtensions/'.basename($classname).'.php')){
            require_once CORE.'/libloader/Classes/iExtensions/'.basename($classname).'.php';
        }else if(file_exists( BASEPATH.'/core/API/Classes/'.$classname.'.php')){
            require_once BASEPATH.'/core/API/Classes/'.$classname.'.php';
        }
        else if(file_exists( LIBS.'/classes/'.$classname.'.php')){
            require_once  LIBS.'/classes/'.$classname.'.php';
        }
    }
}
spl_autoload_register('classAutoLoader');




//include config file
require_once 'FramelessConfig.php';





/**********************************Custom bootstraps******************************************/