<?php


namespace IFramelessPHP\route;

use FramelessPHP\ibase\Web;

/**
 @version 1.0 <br>
 * Class iAppRoute - As of version 1.0 this is the primary router class.
 * While in traditional routing acts as a separate module, The router is actually integrated within the framework.
 * As a result, if users use the framework as built, they will never directly interact with this class.
 * @package libloader\ibase
 */
class iAppRoute
{
    private $route,$params=array(), $routeList, $resource, $routeParam;

    /**
     * iAppRoute constructor. - The entry point into the router
     * @param $routeParam - The url param to check for that will dictate which route to use.<br>
     * If user did not manually set route params, the framework does it for you ny default.
     */
    function __construct($routeParam){
        $this->routeParam = $routeParam;
        $this->cleanParams();
    }

    /**
     * scanner function is ran to get current route. However if the route that is passed
     * was not registered, the current route will be set to /404.
     */
    function scanner(){
        if(strlen(trim(rtrim($_REQUEST[$this->routeParam])))>0){
            $this->resource = explode("/", rtrim($_REQUEST[$this->routeParam]));
            $route = '/'.$this->resource[0];
            unset($this->resource[0]);
           $this->resource = implode('/',array_values($this->resource));
            if(in_array($route, $this->routeList)){
                $this->route = $route;
            }else{
                $this->route ='/404';
            }
        }else{
            $this->route='/';
        }
    }

    /**
     * Register a route
     * @param $route - the name of the route to register.
     * <br>
     * register('/home')
     */
    public function register($route){
        if(is_array($route)){
            foreach ($route as $r){
                $this->routeList[] = $r;
            }
        }else{
            $this->routeList[] = $route;
        }

    }


    function __destruct()
    {
        unset($this->route);
        unset($this->params);
        unset($this->routeList);
        unset($this->resource);
        unset($this->routeParam);
    }


    /**
     * Cleans the param and makes sure it does not contain any data that
     * might be harmful to the application. However, the user should still sanitize their data.
     */
    private function cleanParams(){
        $brokenUrl = explode("&", Web::currentUrl());
        unset($brokenUrl[0]);
        $brokenUrl = array_values($brokenUrl);
        foreach ($brokenUrl as $param){
            $paramaters = explode("=",$param);
            $this->params[$paramaters[0]] = $paramaters[1];
        }

    }

    /**
     * Get params from url
     * @param $name - The name of the param to search for
     * @return mixed - Return the param value if found or return null if param was not found.
     */
    public function getParams($name)
    {
        if(isset($this->params[$name])){
            return $this->params[$name] ;
        }else{ return null; }

    }

    /**
     * Returns the current route
     * @return string - The value of the route
     */
    public function getRoute(){
        return $this->route;
    }

    /**
     * Return all resources associated with the url after the route
     * @return array - Array of each resource.<br>
     * Example: url = 'http://site.com/users/getUsers
     <br> route in this example is users while the resource is getUsers
     */
    public function getResource(){
        return $this->resource;
    }

}