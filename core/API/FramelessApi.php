<?php

/**
 * Created by PhpStorm.
 * User: iceman5508
 * Date: 1/20/2018
 * Time: 10:17 PM
 */
class framelessApi
{

    private $route;

    public function __construct(){
        $var = FramelessConfig::$api['var'];
        if(strlen(trim($var)) < 1){
            echo "Developer must set a  request key";
            return;
        }
        $this->route =  new \IFramelessPHP\route\iAppRoute($var);

        $this->route->register('');
        if(isset($_REQUEST[$var])){
            $route = explode("/", rtrim($_REQUEST[$var]))[0];
        }else{
            echo "requests must use the {$var} key";
            return;
        }


        if(isset($_REQUEST[$var]) && in_array($route,FramelessConfig::$api['resources'])){

            $this->route->register('/'.$route);
            $this->pullRequests();

            $folder = FramelessConfig::$api['folder'];
            if(strlen(trim($folder))<1){
                echo 'No API PATH FOUND!';
                return;
            }
            $location = $folder.'/'.$route.'.php';

            if(file_exists($location)) {
                require_once $location;
                $apiClass = new $route($this->getFullResource());
                print $apiClass->response();

            }else{

                print $route.' is not a resource.';
            }

        }else{
            print 'No Resource Found';
        }
    }

    /**
     * Scan requests and pull information
     */
    private function pullRequests(){
        $this->route->scanner();
    }


    /**
     * Get the full framelessApi call
     * @return array
     */
    private function getFullResource(){
        return $this->route->getResource();
    }


    function __destruct()
    {
        unset($this->route);

    }



}

