<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class Web - This class handles web specific information.
 * @package FramelessPHP\ibase
 */
class Web
{

    /**
     * Return the http request header
     * @return mixed
     */
    public static function httpRequestHeader(){
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Return all http headers
     * @return array|false
     */
    public static function allHttpHeaders(){
        return getallheaders();
    }

    /**
     * Write http header
     * @param $header - the header information for example
     * Content-Type: image/png
     * @param boolean $multiple - set to true if header being set was already set and you dont wish to overwrite
     * the previous header.
     */
    public static function writeHttpHeader($header, $multiple=false){
        if($multiple){
            header($header, true);
        }else
            header($header);
    }

    /**
     * Set the http response code
     * @param $code - code to set to
     */
    public static function setHttpStatusCode($code){
       if(is_numeric($code)){
           http_response_code($code);
       }
    }

    /**
     * Return the path environment variable
     * @return array|false|string
     */
    public static function environmentPath(){
        return getenv('PATH');
    }

    /**
     * Return the home environment variable
     * This is useful in unix systems
     * @return array|false|string
     */
    public static function environmentHome(){
        return getenv('Home');
    }

    /**
     * Return the user environment
     * @return array|false|string
     */
    public static function environmentUser(){
        return getenv('USER');
    }

    /**
     * Returns the ip address of the current user
     * @return string
     */
    public static function getIp() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * Get the name of the current page
     * @return string
     */
    public static function pageName(){
        $pageName =  basename($_SERVER['PHP_SELF']);
        return $pageName;
    }

    /**
     * Get the current url being viewed
     * @return string
     */
    public static function currentUrl() {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
    }


    /**
     * Get the current path
     * @return string
     */
    public static function currentPath(){
        return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    }

    /**
     * Return the path of the parent file
     * @return string
     */
    public static function parentPath(){
        $array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
        unset($array[sizeof($array)-1]);
        $location = implode("/", $array);
        return $location;
    }

    /**
     * Return the url of the parent file/dir
     * @return string
     */
    public static function parentUrl(){
        $array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
        unset($array[sizeof($array)-1]);
        $location = implode("/", $array);
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
           $location,
            ''
        );


    }


    /**
     * Return the project path of the current file
     * @return string
     */
    public static function projectPath(){
        $array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
        $location = $array[0]."/".$array[1];
        return $location;

    }


    /**
     * Return the project url of the current page
     * @return string
     */
    public static function projectUrl(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',

           self::projectPath(),


            '/'
        );
    }

    /**
     * Return the current host
     * @return string
     */
    public static function host(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'],
            ''
        );
    }

    /**
     * Remove the extension of the url, returning only the file/path
     * @return mixed
     */
    public static function removeUrlEx(){
       $activeURL = sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $activeURL);
        return $withoutExt;
    }

    /**
     * Redirects the user to a safe version of the requested url without a trailing back slash
     */
    public static function removeLastSlash(){
        $activeURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(substr($activeURL, -1) == '/') {
            $safe_url = rtrim($activeURL, '/');
            header( 'Location: '.$safe_url.'' ) ;
        }
    }

    /**
     * Redirects the user to the given url path
     * @param null $location
     */
    public static function redirect_to( $location = NULL ) {
        if ($location != NULL) {
            header("Location: {$location}");
            exit;
        }
    }

    /**
     * Check if the link is the currently viewed page
     * @param $linkName - The name to check against
     * @return bool
     */
    public static function currentPage($linkName){
        $currentPageName =  basename($_SERVER['PHP_SELF']);
        if(strpos($currentPageName, $linkName)!==false)
        {
            return true;
        }
        else return false;
    }


    /**
     * Get the previously viewed page
     * @return mixed
     */
    public static function previousPage(){

        if(isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'] ;
        }
        else return self::currentUrl();
    }

    /**
     * Returns an array of the url
     * @param $url - The url to break
     * @return array
     */
    public static function breakUrl($url){

        return explode("/", $url);
    }

    /**
     * Returns the absolute root location of a project
     * @return string
     */
    public static function absoluteRoot(){
        return __DIR__;
    }




}