<?php
namespace FramelessPHP\ibase;
/**
* @version 1.0<br>
 * This class provides an abstract framelessApi class from which other framelessApi classes
 * or resources can be created.
 *
 * credit to http://coreymaynard.com/blog/creating-a-restful-api-with-php/
 * for full tutorial and code inspiration.
 */
abstract class API
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: PUT
     * Stores the input of the PUT request
     */
    protected $_PUT = Null;

    /**
     * Property: PUT
     * Stores the input of the PUT request
     */
    protected $_PATCH = Null;

    /**
     * Property: PUT
     * Stores the input of the PUT request
     */
    protected $_DELETE = Null;

    /**
     * Property: properties
     * Stores all additional information passed to url after resource call.
     */
    protected $properties = Array();




    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct($request) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->args = explode('/', rtrim($request, '/'));
        $this->properties = $this->args;

        unset($this->properties[0]);
        $this->properties = array_values($this->properties);

        $this->endpoint = array_shift($this->args);


        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }



        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }



        switch($this->method) {
            case 'DELETE':
                $this->request = $this->_cleanInputs($_GET);
                parse_str(file_get_contents('php://input'), $_DELETE);
                $this->_DELETE = $_DELETE;
                break;
            case 'POST':
                $this->request = $this->_cleanInputs($_POST);
                break;
            case 'GET':
                $this->request = $this->_cleanInputs($_GET);
                break;
            case 'PATCH':
                $this->request = $this->_cleanInputs($_GET);
                parse_str(file_get_contents('php://input'), $_PATCH);
                $this->_PATCH = $_PATCH;
                break;
            case 'PUT':
                $this->request = $this->_cleanInputs($_GET);
                parse_str(file_get_contents('php://input'), $_PUT);
                $this->_PUT = $_PUT;
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }

    }


    /**Method: response
     * Processes the request and returns the result.
     * @return string
     */
    public function response() {
        if (method_exists($this, $this->endpoint)) {

            return $this->_response($this->{$this->endpoint}($this->_cleanInputs($this->properties)));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    /**
     * Method: status
     * Returns the connection status
     * @return int
     */
    public function status()
    {
        return http_response_code();
    }

    /**
     * Method: set status
     * set the connection status
     * @var stat: the status code to return
     */
    public function set_status($stat)
    {
        http_response_code($stat);
    }


    /**
     * Returns an associative array of the passed data.
     * @return mixed
     */
    public function requestParams(){
        $request = $_REQUEST;
        array_shift($request);
        return $request;
    }





    /******************************Private methods*************************************/
    private function _response($data, $status = 200) {

        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

}