<?php

/**
 * Validate a credit card number
 * @param $str - The credit card number to validate
 * @return int
 */
function ivalid_ccnum($str){
    return preg_match('/^\d{16}$/' ,$str);
}


/**
 * Validate credit card expiration date
 * @param $str - The date in string form
 * @return int
 */
function ivalid_cexp($str){
    return preg_match('/(0[1-9]|1[0-2])\/20[0-9]{2}$/', $str);
}


/**
 * Validate international phone number
 * @param $str - The number to validate
 * @return int
 */
function ivalid_int($str){
    return preg_match('/^(\+|00)[1-9]{1,3}(\.|\s|-)?([0-9]{1,5}(\.|\s|-)?){1,3}$/', $str);
}

/**
 * Validate a US. number
 * @param $str - The number to validate
 * @return int
 */
function ivalid_usnum($str){
    return preg_match('/^[2-9]\d{2}-\d{3}-\d{4}$/', $str);
}


/**
 * Validate an indian number
 * @param $str - The number to validate
 * @return int
 */
function ivalid_indinum($str){
    return preg_match('/^\(0\d{2}\)\s?\d{8}$/', $str);
}


/**
 * Validate a social security number
 * @param $str
 * @return int
 */
function ivalid_ssn($str){
    return preg_match('/^\d{3}\-\d{2}\-\d{4}$/', $str);
}


/**
 * Validate email
 * @param $str - The email to validate
 * @return int
 */
function ivalid_email($str){
    return preg_match('/^([a-z0-9_-])+([\.a-z0-9_-])*@([a-z0-9-])+(\.[a-z0-9-]+)*\.([a-z]{2,6})$/', $str);
}


/**
 * Validate a url
 * @param $str - The url to validate
 * @return int
 */
function ivalid_url($str){
    return preg_match('/^(http|https|ftp):\/\/([a-z0-9]([a-z0-9_-]*[a-z0-9])?\.)+[a-z]{2,6}\/?([a-z0-9\?\._-~&#=+%]*)?/', $str);
}


/**
 * Validates if the file passed is an image
 * <br>
 * Note is image only check for basic image files
 *if you wish to create a full proof image checker that goes beyond just
 *the basic file names you can extend the function
 * @param $value - the filename to check
 * @return bool
 */
function is_image($value){
    if(strpos($value, '.jpeg')!==false) {
        if(substr($value, -5) == '.jpeg') {
            return true;
        }else return false;
    } else if(strpos($value,'.jpg')!==false) {
        if(substr($value, -4) == '.jpg') {
            return true;
        }else return false;
    }
    else if(strpos($value,'.bmp')!==false) {
        if(substr($value, -4) == '.bmp') {
            return true;
        }else return false;
    }else if( strpos($value,'.png')!==false) {
        if(substr($value, -4) == '.png') {
            return true;
        }else return false;
    }else if(strpos($value,'.gif')!==false) {
        if(substr($value, -4) == '.gif') {
            return true;
        }else return false;
    }else return false;
}


/**
 * check if the file passed was a text (txt) file
 * @param $file - the filename name
 * @return bool
 */
    function is_textfile($file){
        if(strpos($file, '.txt')!==false) {
            if(substr($file, -4) == '.txt') {
                return true;
            }else return false;
        }
        else return false;
    }

/**
 * Search a file and check if specific item is an mp3 file
 * @param $file - The file to validate
 * @return bool
 */
function is_mp3($file){
    if(strpos($file, '.mp3')!==false) {
        if(substr($file, -4) == '.mp3') {
            return true;
        }else return false;
    }
    else return false;
}



/**
 * Check if the file is a csv
 * @param $file - The file to validate
 * @return bool
 */
function is_csv($file){
    if(strpos($file, '.csv')!==false) {
        if(substr($file, -4) == '.csv') {
            return true;
        }else return false;
    }
    else return false;
}

/**
 * Check if the data present is empty or not
 * @param $data - The data to validate (can be array or string)
 * @return bool
 */
function is_empty($data){
    if(is_array($data)) {
        return (sizeof($data)>0 ? true: false);

    }
    if(is_string($data)) {
        return (preg_match('/\S/', $data) ? false: true);

    }
    return true;
}


/**
 * Check if the presented string is a url or not
 * @param $url - The string to validate
 * @return bool
 */
function is_url($url){
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
        return true;
    } else {
        return false;
    }
}


/**
 * Search if the data presented is a specific type of data.
 * @param $type - the data type expecting. options are (bool, string,number, array)
 * @param $value - The data that is passed
 * @return bool
 */
function ivalid_dataType($type, $value){
    $valid = false;
    switch ($type){
        case 'bool':
            is_bool($value)? $valid = true : $valid=false;
            break;
        case 'string':
            is_string($value)? $valid = true : $valid=false;
            break;
        case 'number':
            is_numeric($value)? $valid = true : $valid=false;
            break;
        case 'array':
            is_array($value)? $valid = true : $valid=false;
            break;
        default:
            break;
    }
    return $valid;
}

