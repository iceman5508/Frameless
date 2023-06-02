<?php


namespace FramelessPHP\iExtends;
use FramelessPHP\ibase\Database;
use mysqli;


/**
 * @version 1.0<br>
 * Class can act as another database class, but primary purpose is to
 * handle seamless migration of data.
 * Class Migration
 * @package FramelessPHP\iExtends
 */
class Migration
{
    private $myqli = null, $connect = false, $error=array(), $results =array();
    private $host,$username,$password,$database = null;

    /**
     * Migration constructor.
     * Gateway into database connection
     * @param $servername - The server name
     * @param $username-  server username
     * @param $password - server password
     */
    public function __construct($servername, $username, $password){
        $this->myqli = new mysqli($servername, $username, $password);
        if ($this->myqli ->connect_error) {
            $this->connect = false;
            $this->error[] = $this->myqli->connect_error;
        }else{
            $this->connect = true;
            $this->username = $username;
            $this->password = $password;
            $this->host = $servername;

        }


        return $this;
    }





    /**
     * Create a new database
     * @param $databasename - the name of the database to create
     * @return bool
     */
    public function createDatabase($databasename){
        $sql = "CREATE DATABASE IF NOT EXISTS {$databasename}";
        if($this->connect){
            if ($this->myqli->query($sql) === TRUE) {
                return true;
            } else {
                $this->error[]= $this->myqli->error;
                return false;
            }
        }
        return false;
    }
    /**
     * Check if database exists
     * @param $databasename - the name of the database to check
     * @return bool
     */
    public function databaseExists($databasename){

        if($this->connect){
            if(mysqli_select_db($this->myqli,$databasename)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * connect to a database
     * @param $databasename
     * @return bool
     */
    public function connectToDB($databasename){
        if($this->databaseExists($databasename)){
            $this->database = $databasename;
            Database::iDBaseConfig($this->host,$this->database,$this->username,$this->password);
            return true;
        }
        return false;
    }

    /**
     * Delete a database
     * @param $databasename
     * @return bool
     */
    public function deleteDatabase($databasename){
        $sql = "DROP DATABASE {$databasename}";
        return $this->query($sql);
    }

    /**
     * Create a new table to a database
     * @param $tableName
     * @return bool
     */
    public function createTable($tableName){
        $sql = "
                CREATE TABLE {$tableName} 
                (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY);
        ";
        $this->query($sql);
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /*
     * Create a new tables to a database
     * @param $tableName
     * @return bool
     */
    public function createTables($tablesName){
        foreach($tablesName as $table){
            $this->createTable($table);
        }
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /**Delete a table from the database
     * @param $tableName
     * @return bool
     */
    public function deleteTable($tableName){
        $sql = "DROP TABLE {$tableName}";
        $this->query($sql);
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /**
     * Add a column to a table in the db
     * @param $tableName - The name of the table
     * @param $columnName - The name of the column to add
     * @param $datatype - The data type of the column
     * @param $length - The length it should be
     * @return bool
     */
    public function addColumn($tableName, $columnName, $datatype, $length=NULL){
        if(isset($length)){
            $sql = "ALTER TABLE `{$tableName}` ADD `{$columnName}` {$datatype}({$length}) NULL";
        }else{
            $sql = "ALTER TABLE `{$tableName}` ADD `{$columnName}` {$datatype} NULL";
        }

        $this->query($sql);
        if(count($this->error)==0) {
            return true;
        }else
            return false;

    }

    /**
     * * Add a columns to a table in the db
     * @param $tableName - The name of the table to add columns to
     * @param array $columnsArray - the array of the column data
     * @return bool
     */
    public function addColumns($tableName, $columnsArray = array(array())){
        foreach($columnsArray as $column){
            if(isset($column[2])){
                $this->addColumn($tableName,$column[0],$column[1],$column[2] );
            }else{
                $this->addColumn($tableName,$column[0],$column[1] );
            }

        }
        if(count($this->error)==0) {
            return true;
        }else
            return false;

    }

    /**
     * Remove a specific column from the database table
     * @param $tableName
     * @param $columnName
     * @return bool
     */
    public function removeColumn($tableName, $columnName){
        $sql = "ALTER TABLE {$tableName} DROP COLUMN {$columnName}";
        $this->query($sql);
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /**
     * Remove columns from the database table
     * @param $tableName
     * @param $columnsArray
     * @return bool
     */
    public function removeColumns($tableName, $columnsArray = array()){
        foreach($columnsArray as $column){
            $this->removeColumn($tableName, $column);
        }
        if(count($this->error)==0) {
            return true;
        }else
            return false;

    }

    /**
     * Insert data into a database table
     * @param $table - the table to be in
     * @param array $fields - associative array example
     * ('fieldname' => 'value')
     * @return bool
     */
    public function insert($table, $fields = array()){
        EazyDBase::insert($table,$fields);
        $this->results = Database::getInstance()->results();
        if(Database::getInstance()->error()){
            $this->error = true;
            return false;
        }else{
            $this->error = false;
            return true;
        }

    }

    /**
     * A customized update query with custom where checkers
     * @param $table - the table to update
     * @param $whereField - the field name in the table
     * @param $whereEqual - the equal value of the field to check for
     * @param $fieldData - the data to update the field to
     * @return bool
     */
    public function update($table, $whereField,$whereEqual, $fieldData = array()){
        return(EazyDBase::updateCustom($table,$whereField,$whereEqual,$fieldData));

    }

    /**
     * Delete a row from the table
     * @param $table - the table to run the delete query against
     * @param $where array - takes an 3 element array such as array('id', '=', '1')
     * @return bool
     */
    public function delete($table, $where=array()){
        if( EazyDBase::delete($table, $where)){
            $this->results = Database::getInstance()->results();
            return true;
        }else {
            $this->error = Database::getInstance()->error();
            return false;
        }
    }

    /**
     * a get query from the table - returns only one result from the table
     * @param $table - the table to run the get query against
     * @param $where array - takes an 3 element array such as array('id', '=', '1')
     * @return bool
     */
    public function get($table, $where=array()){
        $get = EazyDBase::get($table,$where);
        if($get !== false) {
            if(Database::getInstance()->error())
            {
                $this->error = Database::getInstance()->error();
                return false;
            }else
            if (count($get)> 0) {
                $this->results = $get;
                return true;
            } else {
                $this->results = [];
                return true;
            }
        }
        return false;
    }

    /**
     * Clear all data in a specific table
     * @param $table - The table to clear
     * @return boool
     */
    public function clearTable($table){
        $sql = "DELETE FROM {$table}";
        $this->query($sql);
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /**
     * Delete tables from the database
     * @param array $tables
     * @return bool
     */
    public function deleteTables($tables = array()){
        foreach ($tables as $table) {
            $this->deleteTable($table);
        }
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }

    /**
     * Empty the data from a list of tables
     * @param array $tables
     * @return bool
     */
    public function clearTables($tables = array()){
        foreach ($tables as $table) {
            $this->clearTable($table);
        }
        if(count($this->error)==0) {
            return true;
        }else
            return false;
    }


    /**
     * Destructor method
     */
    function __destruct(){
        if(isset($this->myqli))
        {
            $this->myqli->close();
        }

        unset($this->connect);
        unset($this->error);
        unset($this->myqli);
        unset($this->results);
        unset($this->database);
        unset($this->username);
        unset($this->password);
        unset($this->host);
    }

    /**
     * Close the database connection
     */
    public function closeConnection(){
        $this->__destruct();
    }

    /**
     * Return if a successful connection was made or not
     * @return bool
     */
    public function isConnected(){
        return $this->connect;
    }

    /**
     * Return all errors given
     * @return array
     */
    public function getError(){
        return $this->error;
    }

    /**
     * Return all results given from query
     * @return array
     */
    public function getResults(){
        return $this->results;
    }

    /**
     * query function to make operations a lot easier
     * @param $sql
     * @return bool
     */
    public function query($sql){
        if($this->connect){
            $this->results = $this->myqli->query($sql);

            $mysql_error = [];
            if(gettype($this->myqli->error)=='string'){
                $mysql_error[] = $this->myqli->error;
            }else{
                $mysql_error = $this->myqli->error;
            }
            if ($this->results === TRUE || count($mysql_error) < 1 ) {
                if(!is_bool($this->results)){
                    $this->results = $this->results->fetch_assoc();
                }
                return true;
            } else {
                $temp_er = $this->myqli->error;
                $type=explode(' ',$temp_er);
                if(in_array('Table',$type)&&in_array('already', $type)&&in_array('exists', $type))
                {
                    return true;
                }else{
                    $this->error[]= $temp_er;
                    return false;
                }
            }
        }
        return false;
    }

}