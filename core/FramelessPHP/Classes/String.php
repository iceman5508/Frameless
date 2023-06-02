<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class String - This class handles string related functions.
 * @package FramelessPHP\ibase
 */
class String
{
    protected $string;

    public function __construct($string){
        if(!is_string($string)){
            $string = "".$string;
        }
        $this->string = $string;
    }

    public function __destruct(){
        unset($this->string);
    }


    /**
     * Returns the number of characters the string has
     * @return int
     */
    public function length(){
       return strlen($this->string);
    }

    /**
     * Returns the number of words the string has
     * @return int
     */
    public function wordCount(){
        return sizeof($this->breakIntoWords());
    }

    /**
     * Compare the given string to the string in the String class to see if they are equal
     * This ignores case
     * @param String $string
     * @return  bool
     */
    public function compare_NoCase($string){
        if($string instanceof String) {
            $value = strcasecmp($this->string, $string->getString());
        }else{
            $value = strcasecmp($this->string, $string);
        }
        if($value==0) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * Compare the given string to the string in the String class to see if they are equal
     * @param String $string
     * @return bool
     */
    public function compare($string){
        if($string instanceof String) {
            $value = strcasecmp($this->string, $string->getString());
        }else{
            $value = strcasecmp($this->string, $string);
        }
        if($value==0) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * get the string in the String class
     * @return string
     */
    public function getString()
    {
        return "".$this->string;
    }



    public function __toString()
    {
        return "".$this->string;
    }

    /**
     * Get part of the string
     * @param $action - options are first and last
     * first, set pointer to the start of the string.
     * last, set pointer to the end of the string
     *However action can also be an integer value of where in the
     * string you wish to start
     *
     * @param integer $numberOfChars - number of chars to include.
     * if pointer is first, the char count will be from left to right.
     * if point is last, the char count will be from right to left.
     *
     * @note this method ignores white spaces
     *
     * @return string
     */
    public function subString($action='first',$numberOfChars=0){
        if($numberOfChars<0) { $numberOfChars = $numberOfChars*-1;}
        else if($numberOfChars==0) {
            return $this->string;
        }else if(strcasecmp($action,'last')==0) {
            return substr(trim($this->string), -$numberOfChars);
        }else if(strcasecmp($action,'first')==0) {
            return substr(trim($this->string), 0,$numberOfChars);
        }else if(is_numeric($action)){
            return $this->subString2($action, $numberOfChars);
        }
        return $this->string;
    }

    /**
     * Get x number of words from the string
     *@param $action - options are first and last
     * first, set pointer to the start of the word list.
     * last, set pointer to the end of the word list.
     *However action can also be an integer value of where in the
     * string you wish to start
     * @param int $numberOfWords - the number of words expecting or wanting to be returned
     * @return array
     */
    public function subWords($action='first', $numberOfWords=0){
        $words = $this->breakIntoWords();
        if($numberOfWords<0) { $numberOfWords = $numberOfWords*-1;}
        else if(strcasecmp($action,'last')==0) {
            return array_slice($words, -$numberOfWords, $numberOfWords);
        }else if(strcasecmp($action,'first')==0) {
            return array_slice($words, 0, $numberOfWords);
        }else if(is_numeric($action)){
            return  array_slice($words, $action, $numberOfWords);
        }
        return $words;
    }

    /**
     * Return a specific sub string of the string
     * @param $start - where in the string the pointer should start
     * @param $length - how many characters to return
     * @return bool|string
     */
    private function subString2($start, $length){
        return substr(trim($this->string),$start,$length);
    }

    /**
     * Break string into words
     * return array of strings
     */
    public function breakIntoWords(){
        return explode(" ", trim($this->string));
    }

    /**
     * Check if a given value is in the string.
     * @param String $value
     * @return bool
     */
    public function inString($value){
        if($value instanceof String) {
            $value = $value->getString();
        }
        $words = $this->breakIntoWords();
        $array_found = in_array(trim($value), $words);
        $string_found = strpos($this->string, trim($value));
        if($array_found)
            return true;
        if($string_found)
            return true;
        return false;
    }


    /**
     * Return the first instance of a give value in the string
     * @param String $value - value to search for
     * @return int
     *
     */
    public function firstInstanceOf($value){
        if($value instanceof String) {
            $value = $value->getString();
        }
        if(array_search($value, $this->breakIntoWords())===false) {
            return false;
        }else {
            return array_search($value, $this->breakIntoWords());
        }
    }

    /**
     * Return all instances of a value in the string
     * @param string $value
     * @return bool | mixed
     */
    public function AllInstancesOf($value){
        if($value instanceof String) {
            $value = $value->getString();
        }
        $words = $this->breakIntoWords();
        if(in_array($value, $words)){
                $positions=array();

            for($i=0; $i<sizeof($words); $i++) {
                $found = strcasecmp($words[$i], $value);
                if($found ==0) {
                    $positions[]=$i;
                }
            }
            return $positions;
        }
        return false;
    }

    /**
     * Returns the string with the end being the head.
     * For example if string is "hi my", the return will be
     * "ym hi"
     * @return string
     */
    public function flip(){
        return strrev($this->string);
    }

    /**
     * Returns the word list with the end being the head.
     * For example if words are "hi my", the return will be
     * "ym hi"
     * @return string
     */
    public function flipWords(){
       return explode(" ", trim($this->reverse()));
    }

    /**
     * Return a reversed version of the string
     * @return string
     */
    public function reverse(){
        $words = array_reverse($this->breakIntoWords());
        return implode(" ", $words);
    }

    /**
     * Returns reverse version of the words list
     * @return array
     */
    public function reverseWords(){
        return array_reverse($this->breakIntoWords());

    }

    /**
     * Replace a specific word with a given replacement
     * @param $word - the word to replace
     * @param $replacement - the replacement word
     * @param bool $all - if should replace at all instances of the word
     */
    public function replaceWord($word, $replacement, $all = true){
        if($replacement instanceof String) {
            $replacement = $replacement->getString();
        }
        $words = $this->breakIntoWords();
        if($all){
           foreach( $this->AllInstancesOf($word) as $location ){
               $words[$location] = $replacement;
           }
        }
        else {
            $location = $this->firstInstanceOf($word);
            $words[$location] = $replacement;
        }
        $this->string = implode(" ", $words);
    }

    /**
     * Return a trimmed version of the string
     * @return string
     */
    public function trim(){
        return trim($this->string);
    }

    /**
     * Make the string a lowercase
     * @return string
     */
    public function lowercase(){
        return strtolower($this->string);
    }

    /**
     * make the string a uppercase
     * @return string
     */
    public function uppercase(){
       return strtoupper($this->string);
    }

    /**
     * Append a word to the end of the current word
     * @param $word - the word to add
     */
    public function appendWord($word){
        if($word instanceof String) {
            $word = $word->getString();
        }
        $wordList = $this->breakIntoWords();
        $wordList[] = $word;
        $this->string = implode(" ", $wordList);
    }

    /**
     * Append a string to the end of the current string
     * @param $string - the string to append
     */
    public function appendString($string){
        if($string instanceof String) {
            $string = $string->getString();
        }
        $this->string = $this->string.$string;
    }

    /**
     * Add a word to the string at a specific position
     * @param $word - word to add
     * @param int $position - the position, not required
     */
    public function addWord( $word,$position=-1){
        if($word instanceof String) {
            $word = $word->getString();
        }
        if(!is_numeric($position) || $position < 0){
            $this->appendWord($word);
        }else{
            $wordList = $this->breakIntoWords();
            array_splice( $wordList, $position, 0, array($word) );
            $this->string = implode(" ", $wordList);
        }
    }

    /**
     * Add a string to the current string at a specific position
     * @param $string - the string to add
     * @param int $position - the position to add it in, not required
     * @return mixed|string
     */
    public function addString($string, $position=-1){
        if($string instanceof String) {
            $string = $string->getString();
        }
        if(!is_numeric($position) || $position < 0){
           $position = $this->length();
        }
        $this->string = substr_replace($this->string, $string, $position, 0);
        return $this->string;
    }


    /**
     * Return an array of the string
     * @param string $deliminator - whatever deliminator to break string by
     * @return array
     */
    public function strArray($deliminator=" "){
        return explode($deliminator, $this->string);
    }

    /**Wrap string at every given count with the passed wrapper
     * @param $count - the char limit at which to wrap
     * @param $wrapper - what to wrap the text with for example , div or \n
     * @return string
     */
    public function wrapAt($count, $wrapper){
        return wordwrap($this->string,$count,$wrapper);

    }






}