<?php

namespace FramelessPHP\ibase;
use \PDO;
use \PDOException;

/**
 * @version 1.0<br>
 * Class Database  - This class is an OOP method for database connection through pdo.
 * @package FramelessPHP\ibase
 */
class Database
{
    private static $config = array('host' => '', 'databasename' =>'', 'username' => '', 'password' => '');
    private static $instance = NULL;
    private $pdo, $error, $query, $results, $count;

    private function __clone(){}

    private function __wakeup(){}

    private function __construct(){
        try {
            $this->pdo = new PDO('mysql:host='.self::$config['host'].';
            dbname='.self::$config['databasename'].'', self::$config['username'],self::$config['password']);
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }


    function __destruct() {

        unset($this->pdo);
        unset($this->query);
        unset($this->error);
        unset($this->results);
        unset($this->count);
    }

    /**
     * Get the current instance of the database class
     * @return Database |null
     */
    public static function getInstance(){
        if(!isset(self::$instance)) {

            self::$instance = new Database ();
        }
        return self::$instance;
    }
    
    /**
     * Configure the database based on information needed
     * @param $host
     * @param $databasename
     * @param $username
     * @param $password
     */
    public static function iDBaseConfig($host,$databasename, $username, $password){
        self::$config['host'] = $host;
        self::$config['databasename'] = $databasename;
        self::$config['username'] = $username;
        self::$config['password'] = $password;
    }

    /**
     * return the error from the execution
     * @return mixed
     */
    public function error(){
        return $this->error;
    }

    /**
     * Return the rows returned from the query
     * @return mixed
     */
    public function count(){
        return $this->count;
    }

    /**
     * Return the results from the query ran
     * @return mixed
     */
    public function results(){
        return $this->results;
    }

    /**
     * Return the first result from the query
     * @return mixed
     */
    public function first(){
        $result = $this->results();
        return $result[0];
    }

    /**
     * Run a get query to the database
     * @param $table
     * @param $where takes an 3 element array such as array('id', '=', '1')
     * @return mixed
     */
    public function getQuery($table, $where){
        return $this->action('SELECT *',$table,$where);
    }

    /**
     * Run a delete query to the database
     * @param $table
     * @param $where takes an 3 element array such as array('id', '=', '1')
     * @return mixed
     */
    public function deleteQuery($table, $where){
        return $this->action('DELETE',$table,$where);
    }


    /**
     * Run a insert query to the database
     * @param $table
     * @param $fields
     * @return mixed
     */
    public function insertQuery($table , $fields = array()){
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = ' ';
            $x= 1;
            foreach($fields as $field) {
                $values .= '?';
                if($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            $sql = 'INSERT INTO '.$table.' (`'.implode('`, `', $keys).'`)VALUES('.$values.')';

            if(!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        return false;
    }


    /**
     * Run a update query to the database
     * @param $table
     * @param $id
     * @param $fields
     * @return mixed
     */
    public function updateQuery($table, $id, $fields){
        $set = ' ';
        $x=1;
        foreach($fields as $field => $value)
        {
            $set .= ''.$field.' = ? ';
            if($x < count($fields))
            {
                $set .= ' , ';
            }
            $x++;
        }

        $sql = 'UPDATE '.$table.' SET '.$set.' WHERE id = '.$id.' ';
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }else {
            return false;
        }
    }


    /**
     * Run a update query to the database
     * @param $table
     * @param $whereColumn - the column to check
     * @param $whereValue - The value to match where at
     * @param $fields
     * @return mixed
     */
    public function updateQueryC($table, $whereColumn,$whereValue, $fields){
        $set = ' ';
        $x=1;
        foreach($fields as $field => $value)
        {
            $set .= ''.$field.' = ? ';
            if($x < count($fields))
            {
                $set .= ' , ';
            }
            $x++;
        }

        $sql = 'UPDATE '.$table.' SET '.$set.' WHERE '.$whereColumn.' = '."'$whereValue'".' ';
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }else {
            return false;
        }

    }
    /**
     * Run the sql query provided
     * @param $sql
     * @return $this
     */
    public function simpleQuery($sql){
        $this->error=false;
        if($this->query = $this->pdo->prepare($sql)) {
            if($this->query->execute()) {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            }else {
                $this->error = true;
            }
        }
        return $this;
    }

    /**
     * Run the the query provided as well as the params given
     * @param $sql - the sql to run
     * @param array $params - the params to pass to the query
     * @return $this
     */
    public function query($sql, $params = array()){
        $this->error=false;
        if($this->query = $this->pdo->prepare($sql)) {
            $n=1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->query->bindValue($n, $param);
                    $n++;
                }
            }
            if($this->query->execute()) {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else {
                var_dump($this->query->errorInfo());
                $this->error = true;
            }
        }
        return $this;
    }

    /**
     * @param $action
     * @param $table
     * @param array $where
     * @return $this|bool
     */
    private function action($action, $table, $where = array()){

        if(count($where)===3) {
            $operator = array('>','<','<=','>=','=','!=', 'AND','NOT','OR','+','-','%','*','/','<>','!<','!>','ALL','LIKE');

            $field = $where[0];
            $op = $where[1];
            $value = $where[2];
            if(in_array($op,$operator)) {
                if(is_array($table)) {
                    $sql = ''.$action.' FROM '.$table[0].','.$table[1].' WHERE '.$field.''.$op.'?';
                } else {
                    $sql = ''.$action.' FROM '.$table.' WHERE '.$field.''.$op.'?';
                }
                if(!$this->query($sql, array($value))->error()) {
                    return $this;

                }
            }

        }
        return false;
    }

}