<?php

namespace FramelessPHP\iExtends;


use FramelessPHP\ibase\Directory;
use FramelessPHP\ibase\File;

/**
* @version 1.0<br>
 * This class leverages the File and Directory classes
 * to handle full file systems

* @package FramelessPHP\iExtends
 */
class FileSystems
{

    /**
     * Returns an array of thhe timestamp information
     * for the file or directory.
     * The array include the last time the file was accessed, last time it was modified
     * and last time it was changed.
     * @param $fileOrDir
     * @return array
     */
    public static function getTimestamp($fileOrDir){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        return array('last_access' => fileatime($fileOrDir),
            'last_mod' => filemtime($fileOrDir), 'last_change' => filectime($fileOrDir));
    }

    /**
     * Update the modification timestamp of the file or directory.
     * @param $fileOrDir
     * @param null $timestamp - if no timestamp provided the current
     * timestamp is used
     */
    public static function updateModification($fileOrDir, $timestamp = NULL){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        if ($timestamp !== NULL) {
            touch($fileOrDir, $timestamp);
        } else {
            touch($fileOrDir);
        }
    }

    /**
     * Change the permissions of the file or directory
     * @param $fileOrDir
     * @param $permissions - values can be
     * 'owner' or 'group' - if left blank file permissions will be changed
     * with no owner or group ties
     * @param $data - the data can be the name of $permissions
     * or the id of the $permissions
     */
    public static function changePermission($fileOrDir, $permissions = 'mod', $data){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        if ($permissions == 'owner') {
            chown($fileOrDir, $data);
        } else if ($permissions == 'group') {
            chgrp($fileOrDir, $data);
        } else {
            if (is_numeric($data)) {
                chmod($fileOrDir, $data);
            }
        }
    }

    /**
     * Return an array of the path infomation for the file or directory
     * The array includes the directory name, base name and extension
     * @param $fileOrDir
     * @return mixed
     */
    public static function getPathInfo($fileOrDir){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        return pathinfo($fileOrDir);
    }

    /**
     * Return the current directory the file or directory is in
     * @return string
     */
    public static function getCurrentDirectory(){
        return dirname(__FILE__);
    }

    /**
     * Delete a directory or file
     * @param $fileOrDir
     */
    public static function delete($fileOrDir){
        if ($fileOrDir instanceof File) {
            $fileOrDir->deleteFile();
        } else if (Directory::dirExists($fileOrDir)) {
            Directory::deleteDir($fileOrDir);
        } else {
            unlink($fileOrDir);
        }
    }

    /**
     * Copy a file or directory to a given location
     * @param $fileOrDir
     * @param $copyTo
     */
    public static function copyTo($fileOrDir, $copyTo){
        if ($fileOrDir instanceof File) {
            $fileOrDir->copyFileTo($copyTo);
        } else if (Directory::dirExists($fileOrDir)) {
            Directory::copyDir($fileOrDir, $copyTo);
        } else {
            copy($fileOrDir, $copyTo);
        }
    }


    /**
     * move a file or directory to a given location
     * @param $fileOrDir
     * @param $copyTo
     */
    public static function moveTo($fileOrDir, $copyTo){
        if ($fileOrDir instanceof File) {
            $fileOrDir->moveFileTo($copyTo);
        } else if (Directory::dirExists($fileOrDir)) {
            Directory::moveDir($fileOrDir, $copyTo);
        } else {
           rename($fileOrDir, $copyTo);
        }
    }

    /**
     * Get an array of all the files in a directory
     * @param $dirName
     * @return array
     */
    public static function getFilesInDir($dirName){
        return Directory::listAllContent($dirName);
    }

    /**
     * Create a new File
     * @param $filename
     */
    public static function createFile($filename){
       $file =  new File($filename);
       $file->createFile();
        $file->__destruct();
    }

    /**
     * Create a new directory
     * @param $directoryName
     */
    public static function createDir($directoryName){
       Directory::createDir($directoryName);

    }

    /**
     * Return the permissions number of the file or directory
     * @param $fileOrDir
     * @return bool|string
     */
    public static function getPermissions($fileOrDir){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        return substr((sprintf('%o', fileperms($fileOrDir))), -4);
    }

    /**
     * Return the owner of the file or directory
     * @param $fileOrDir
     * @return bool|string
     */
    public static function getOwner($fileOrDir){
        if ($fileOrDir instanceof File) {
            $fileOrDir = $fileOrDir->getFileName();
        }
        return substr((sprintf('%o', fileowner($fileOrDir))));
    }





}