<?php
/**
 * Created by PhpStorm.
 * User:Isaac Parker
 * Date: 9/5/2017
 * Time: 12:07 AM
 * This class makes it easy to handle database information
 */

namespace FramelessPHP\iExtends;


use FramelessPHP\ibase\Database;

/**
 * @version 1.0<br>
 * Class EazyDBase - This class uses encapsulation on the Database class to
 * interact with the database in an easy to use way.
 * @package FramelessPHP\iExtends
 */
class EazyDBase
{

    /**
     * Update data in a table
     * @param $table - The table to update
     * @param $id - the id to update at
     * @param array $data - associative array example
     * ('fieldname' => 'value')
     * @return bool
     */
    public static function update($table, $id,  $data = array()){
        $get = Database::getInstance()->updateQuery($table, $id, $data);
        if($get->error()==false) {
            return true;
        } else {
            return false;
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
    public static function updateCustom($table, $whereField,$whereEqual, $fieldData = array()){
        Database::getInstance()->updateQueryC($table,$whereField,$whereEqual,$fieldData);
        $error = Database::getInstance()->error();
        if($error===false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Run a custom query
     * @param $sql - The query to run
     * @return results
     */
    public static function query($sql){
        $get = Database::getInstance()->simpleQuery($sql);
        if($get->error()==false) {
            return $get->results();
        } else {
            return false;
        }
    }

    /**
     * Insert data into a database table
     * @param $table - the table to be in
     * @param array $fields - associative array example
     * ('fieldname' => 'value')
     * @return bool
     */
    public static function insert($table, $fields = array()){
        if( Database::getInstance()->insertQuery($table , $fields)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * a get query from the table - returns only one result from the table
     * @param $table - the table to run the get query against
     * @param $where array - takes an 3 element array such as array('id', '=', '1')
     * @return null
     */
    public static function get($table, $where=array()){
        $get = Database::getInstance()->getQuery($table,$where);
        if(!$get->error()) {
            return Database::getInstance()->results();
        } else {
            return null;
        }
    }

    /**
     * Delete a row from the table
     * @param $table - the table to run the delete query against
     * @param $where array - takes an 3 element array such as array('id', '=', '1')
     * @return bool
     */
    public static function delete($table, $where=array()){
        if( Database::getInstance()->deleteQuery($table,$where)) {
            return true;
        }else { return false; }
    }


}