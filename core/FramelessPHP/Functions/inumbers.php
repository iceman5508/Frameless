<?php
/**
 * Created by PhpStorm.
 * User: parker10
 * Date: 9/1/2017
 * Time: 6:19 PM
 */

/**
 * Return a random number between the number ranges given
 * @param $min - The min number to set the random number between
 * @param $max - The max number to set the random number between
 * @return int
 */
function irand_num($min, $max){
    return mt_rand($min, $max);
}

/**
 * Return a degree version of a given radian number
 * @param $radian - The radian to convert to degree
 * @return float
 */
function iradian_2degree($radian){
    return rad2deg($radian);
}

/**
 * Return a radian version of a given degree number
 * @param $degree - The degree to convert to radian
 * @return float
 */
function idegree_2radian($degree){
    return deg2rad($degree);
}

/**
 * Convert a number to binary
 * @param $number - The number that should be converted to binary.
 * @return string
 */
function inumber_2binary($number){
    return decbin($number);
}

/**
 * Convert a number to binary
 * @param $binary - The number that should be converted to binary.
 * @return string
 */
function ibinary_2number($binary){
    return bindec($binary);
}

/**
 * Convert a number to word form
 * @param $number - The number to convert
 * @return bool|mixed|null|string
 */
function inumber_2string($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {

        trigger_error(
            'numToString only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative.inumber_2string(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . inumber_2string($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = inumber_2string($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= inumber_2string($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

/**
 * Convert the number to a roman numeral
 * @param $integer -The integer to convert.
 * @return string
 */
function inumber_2roman($integer){
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90,
        'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0) {
        foreach($table as $rom=>$arb) {
            if($integer >= $arb) {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }
    return $return;
}

/**
 * Return a factorial of the given number
 * @param $n - The number to do a factorial of
 * @return int
 */
function ifactorial($n){
    if($n==1) {
        return 1;
    }
    else
        return $n * ifactorial($n-1);
}

/**
 * Check if a number is prime or not
 * @param $num - The number to check for.
 * @return bool
 */
function is_prime($num){
    if($num == 1) { return false; }
    if($num == 2) { return true; }
    if($num % 2 == 0) { return false; }
    for($i = 3; $i <= ceil(sqrt($num)); $i = $i + 2) {
        if($num % $i == 0) { return false; }
    }   return true;
}

/**
 * Convert a number into a fraction form
 * @param $f - The number to convert.
 * @return string
 */
function ifraction($f){
    $out= ' ';
    $base = floor($f);
    if ($base) {
        $out = $base . ' ';
        $f = $f - $base;
    }
    if ($f != 0) {
        $d = 1;
        while (fmod($f, 1) != 0.0) {
            $f *= 2;
            $d *= 2;
        }
        $n = sprintf('%.0f', $f);
        $d = sprintf('%.0f', $d);
        $out .= $n . '/' . $d;
    }
    return $out;
}

/**
 * Return the evaluation of an equation in fraction form.
 * @param $equation - The equation to run
 * <br>
 * Example: ifraction_math(1/2 + 1/3)
 * @return mixed
 */
function ifraction_math($equation){
     return ifraction($equation);
}



