<?php

use FramelessPHP\ibase\Web;
define('PROJECT', Web::projectUrl());
define('LIBS', BASEPATH.'/libs');
define('VENDORS', Web::projectUrl().'vendors');

/**
 * Author: Isaac Parker
<br>
 * The config class for project, this is a required setup.
 * Through this class you can configure a lot of the project details.
 */
class FramelessConfig
{



    /**
     * The database variable. The information here
     * Is an can be used with code that connects to a database.
     * @var array
     */
    public static $database = [

         'host'  => 'localhost'
        ,'username' => 'root'
        ,'password' => ''
        ,'database' => 'HakiLabsGames'

    ];


    /**
     * Api variable handles all framelessApi details
     * var - The framelessApi query key to use when connecting to framelessApi
     * <br>
     * example if var = 'framelessApi':
     * http://site/api/?api=test/getTest
     *
     * The resources variable contain all framelessApi
     * you are using and going to connect to.<br>
     *
     *
     * @var array
     */
    public static $api = [
        'var' => 'api'
        ,'folder' => 'models'
        ,'resources' => [

        ]
    ];


}




