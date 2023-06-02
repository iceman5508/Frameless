<?php

/**
 * Remove html from a string
 * @param $string - The string to clean
 * @return string
 */
function iescape($string)
{
    return htmlentities($string , ENT_QUOTES, 'UTF-8');
}

/**
 * Remove code from the string
 * @param $string - The string to clean
 * @return string
 */
function iremoveCode($string)
{
    return strip_tags($string);
}

/**
 * Remove both code and html tags from the string
 * @param $string - The string to clean
 * @return string
 */
function iescapeCode($string)
{
    $str = iescape($string);
    return iremoveCode($str);
}


