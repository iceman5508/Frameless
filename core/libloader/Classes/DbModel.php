<?php

namespace FramelessPHP\model;
use FramelessPHP\iExtends\Migration;

/**
 * @version 1.0 <br>
 * Class DbModel handles all database table related actions.
 * Since this is an abstract class, it will need to be extended in order to be used.
 * @package libloader\ibase
 */
abstract class DbModel
{
    /**
     * The table that the class will be interacting with.
     * @var
     */
    protected $table;

    /**
     * The migration class object that handles database interaction.
     * @var Migration
     */
    private $imigrate;

    /**
     * iTables constructor. This is the entry point for thr itables class.
     * @param $table - The table that this class will be interacting with.
     */
    final function __construct($table){
        $this->table = $table;

        $this->imigrate = new Migration(\FramelessConfig::$database['host'],
            \FramelessConfig::$database['username'], \FramelessConfig::$database['password']);

        if($this->imigrate->isConnected()){
            $this->preLoad($this->imigrate);
        }

        if($this->imigrate->connectToDB(\FramelessConfig::$database['database'])){
            $this->imigrate->createTable($table);
            $this->up();
        }else{

        }


    }


    /**
     * @param $object
     * @return mixed
     * Run this function after connecting to the db.
     * Passes in the current object
     */
    public abstract function preLoad($object);

    function __destruct(){
        $this->down();
        unset($this->table);
        $this->imigrate->closeConnection();

    }

    /**
     * Migrate up - The action to take place after the constructor is called.
     */
    public abstract function up();


    /**
     * migrate down - The action to take place right before the constructor is called.
     */
    public abstract function down();

    /**
     * Add char - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function char($name, $length = 254){
        $this->imigrate->addColumn($this->table, $name,'char', $length);
    }

    /**
     * Add varchar- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function varchar($name, $length = 254){
        $this->imigrate->addColumn($this->table, $name,'varchar', $length);
    }

    /**
     * Add tinytext To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function tinytext($name, $length = 254){
        $this->imigrate->addColumn($this->table, $name,'tinytext', $length);
    }

    /**
     * Add text - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function text($name, $length = 65534){
        $this->imigrate->addColumn($this->table, $name,'text', $length);
    }

    /**
     * Add blob - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function blob($name, $length = 65534){
        $this->imigrate->addColumn($this->table, $name,'blob', $length);
    }

    /**
     * Add mediumtext - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function mediumtext($name, $length = 16777214){
        $this->imigrate->addColumn($this->table, $name,'mediumtext', $length);
    }

    /**
     * Add MEDIUMBLOB - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function mediumblob($name, $length = 16777214){
        $this->imigrate->addColumn($this->table, $name,'mediumblob', $length);
    }

    /**
     * Add longtext - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function longtext($name, $length = 4294967294){
        $this->imigrate->addColumn($this->table, $name,'longtext', $length);
    }

    /**
     * Add longblob - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function longblob($name, $length = 4294967294){
        $this->imigrate->addColumn($this->table, $name,'longblob', $length);
    }

    /**
     * Add enum - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function enum($name, $length = 65534){
        $this->imigrate->addColumn($this->table, $name,'enum', $length);
    }

    /**
     * Add tinyint- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function tinyint($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'tinyint', $length);
    }

    /**
     * Add smallint- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function smallint($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'smallint', $length);
    }

    /**
     * Add mediumint- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function mediumint($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'mediumint', $length);
    }

    /**
     * Add int- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function int($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'int', $length);
    }

    /**
     * Add bigint- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function bigint($name,$length = NULL){
        $this->imigrate->addColumn($this->table, $name,'bigint', $length);
    }

    /**
     * Add float- To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function float($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'float', $length);
    }

    /**
     * Add double - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function double($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'double', $length);
    }

    /**
     * Add DECIMAL - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function decimal($name, $length = NULL){
        $this->imigrate->addColumn($this->table, $name,'decimal', $length);
    }

    /**
     * Add date - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function date($name, $length = NULL ){
        $this->imigrate->addColumn($this->table, $name,'date', $length);
    }


    /**
     * Add datetime - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function datetime($name, $length = NULL ){
        $this->imigrate->addColumn($this->table, $name,'datetime', $length);
    }


    /**
     * Add timestamp - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function timestamp($name, $length = NULL ){
        $this->imigrate->addColumn($this->table, $name,'timestamp', $length);
    }


    /**
     * Add time - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function time($name, $length = NULL ){
        $this->imigrate->addColumn($this->table, $name,'time', $length);
    }


    /**
     * Add year - To the table
     * @param $name - The name of the column being added
     * @param int $length - The length
     */
    public final function year($name, $length = NULL ){
        $this->imigrate->addColumn($this->table, $name,'year', $length);
    }

    /**
     * Get data from table
     * @param array $where - the where clause to use. However this is in array form.<br>
     * Example $where=array('id', '=',2)
     * @return array- An array of the results or an array of errors if one was found.
     */
    public final function get($where=array()){
        if($this->imigrate->get($this->table, $where)){
            return $this->imigrate->getResults();
        }else{
            if($this->imigrate->getError()){
                return false;
            }
        }
    }

    /**
     * Insert data into the table
     * @param array $fields
     * @return boolean | array
     */
    public final function insert($fields = array()){
        if($this->imigrate->insert($this->table,$fields)){
            return true;
        }else{
            return false;
        }
    }

    /**Update database table
     * @param $whereField
     * @param $whereEqual
     * @param array $fields
     * @return array
     */
    public final function update($whereField, $whereEqual, $fields=array()){
        if($this->imigrate->update($this->table,$whereField, $whereEqual, $fields)){
            return true;
        }else{
            return $this->imigrate->getError();
        }
    }

    /**
     * delete data from the table
     * @param array $where
     * @return array
     */
    public final function delete($where = array()){
        if($this->imigrate->delete($this->table,$where)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Clear the data from a table
     * @return boolean if the table was cleared or not
     */
    public final function clearTableData(){
        return $this->imigrate->clearTable($this->table);
    }

    /**
     * Delete the table
     */
    public final function deleteTable(){
        if($this->imigrate->deleteTable($this->table)){
            $this->__destruct();
        }else{
            return false;
        }
    }

    /**
     * Remove a specific column from the table
     * @param $columnName - The name of the column.
     * @return bool - returns true if removed, false if not removed.
     */
    public final function removeColumn($columnName){
        return $this->imigrate->removeColumn($this->table, $columnName);
    }

}
