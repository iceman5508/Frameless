<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class File. This class handles interaction with files.
 * @package FramelessPHP\ibase
 */
class File
{
    private $filename, $exists, $lines = 0, $size = 0, $wordCount = 0;

    /**
     * File constructor. The entry point of the class.
     * @param $file - The file to work on.
     */
    function __construct($file) {
        if (file_exists ( $file ) && is_file ( $file )) {
            $this->filename = $file;
            $this->exists = true;
            $this->setMetta ();
        } else {
            $this->filename = $file;
            $this->exists = false;
        }
        return $this;
    }

    function __destruct() {
        unset ( $this->wordCount );
        unset ( $this->size );
        unset ( $this->filename );
        unset ( $this->exists );
        unset ( $this->lines );
    }

    /**
     * return the name of the file
     * @return mixed
     */
    public function getFileName(){
        return $this->filename;
    }

    /**
     * Return the number of lines the file has
     * @return int
     */
    public function numLines() {
        return $this->lines;
    }

    /**
     * Return the size of the file
     * @return int
     */
    public function size() {
        return $this->size;
    }

    /**
     * return the count of the number of words in the file
     * @return int
     */
    public function wordCount() {
        return $this->wordCount;
    }

    /**
     * Return the index of a specific word in the file
     * @param $value - The value to look for the file.
     * @return int
     */
    public function indexOfWord($value) {
        $words = $this->readFileByWord ();
        $count = 0;
        $found = false;
        for($i = 0; $i < sizeof($words); $i ++) {
            $word = $words [$i];
            if (trim ($value) == trim($word)) {
                $found = true;
                break;
            } else {
                $count ++;
            }
        }
        return ($found == true ? $count : - 1);
    }

    /**
     * Creates a new file
     * @return $this
     */
    public function createFile() {
        if ($this->exists) {
            return $this;
        } else {
            // create file
            $handler = fopen ( $this->filename, 'w' ) or die ('Error Please try again!');
            fclose ( $handler );
            $this->setMetta ();
            $this->exists = true;
            return $this;
        }
    }

    /**
     * Delete the current file
     * @return bool
     */
    public function deleteFile() {
        if ($this->exists) {
            unlink ( $this->filename ) or die ('Error Please try again!');
            $this->exists = false;
            $this->__destruct ();
            return true;
        } else {

            return false;
        }
    }

    /**
     * read file by line.
     * This should return an array of the file's content. <br>
     * With each array index representing the line-1
     */
    public function readByLine() {
        if ($this->exists) {
            $lines = file ( $this->filename ); // file in to an array
            return $lines; // line 2
        } else {
            return false;
        }
    }

    /**
     * Read file from a specific line     *
     * @param $index int
     *       	 - the index number to check at
     * @return string boolean returns the string of the file at the given index
     */
    public function readAtLine($index) {
        if ($this->exists && $index < $this->lines) {
            $lines = $this->readByLine ();
            return trim ( $lines [$index] );
        } else {
            return false;
        }
    }

    /**
     * Return the line index a specific word is in
     * @param $value - The value to search for
     * @return array
     */
    public function indexOfLine($value){
        $instance=array();
        for ($i = 0; $i < $this->lines; $i++) {
            $wordsLine = $this->readAtLine($i);
            $words = explode(" ", trim($wordsLine));
            if (in_array($value, $words)) {
                $instance = array();

                for ($y = 0; $y < sizeof($words); $y++) {
                    $found = strcasecmp($words[$y], $value);
                    if ($found == 0) {
                        $instance[$i] = $y;
                    }
                }
            }
            return $instance;
        }
        return $instance;
    }

    /**
     * Get a specific word at the given line and index of the line
     * @param $line - The line to search on
     * @param $index - The index to search on the line.
     * @return mixed
     */
    public function getWordByLineIndex($line, $index) {
        $lines = $this->readAtLine ( $line );
        $words = explode ( " ", $lines );
        return $words [$index];

    }

    /**
     * Read the file to a string and return that string
     * @return bool|string
     */
    public function readToString() {
        if ($this->exists) {
            // read file
            return file_get_contents ( $this->filename );
        } else {
            return false;
        }
    }

    /**
     * Append data to the end of the file. Note
     * that this does not append a new line at the end
     * of the file
     * @param $data - The data to append in the file.
     * @return $this
     */
    public function append($data) {
        if ($this->exists) {
            $handle = fopen ( $this->filename, "a" ) or die ('Error please try again!');
            fwrite ( $handle, $data );
            fclose ( $handle );
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Append data at the end of the file and place a line break
     * at the end of the content
     * @param $data - The data to add to the file.
     * @return $this
     */
    public function appendNewLine($data) {
        if ($this->exists) {
            $handle = fopen ( $this->filename, "a" )  or die ('Error please try again!');
            fwrite ( $handle, "\n" . $data );
            fclose ( $handle );
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Write data to the file
     * @param $data - The data to write to the file.
     * @param null $line - The line to write on (optional)
     * @param null $index - The index to write at (optional)
     * @return $this|File
     */
    function writeToFile($data, $line = NULL, $index = NULL) {
        if ($this->exists && $data !== null) {
            if ($line == null && $index == null) {
                if ($this->wordCount > 0) {
                    return $this->appendNewLine ( $data );
                } else {
                    return $this->append ( $data );
                }
            } else if ($line !== null && $index === null) {
                if ($line > - 1 && $line < $this->lines) {
                    $words = $this->readAtLine ( $line );
                    $words = $words . " " . $data . "\n";
                    $lines = $this->readByLine ();
                    $lines [$line] = $words;
                    $this->clearFile ();
                    for($i = 0; $i < sizeof ( $lines ); $i ++) {
                        $this->writeToFile ( $lines [$i] );
                    }
                    return $this;
                } else {
                    return $this;
                }
            } else if ($line !== null && $index !== null) {
                $words = $this->readAtLine ( $line );
                $wordList = explode ( " ", $words );
                $arrayList = array();
                for($i = 0; $i < sizeof ( $wordList ); $i ++) {
                    $arrayList[] = $wordList [$i];
                }
                array_splice( $arrayList, $index, 0, array($data) );
                $wordList = array ();
                for($i = 0; $i < sizeof($arrayList); $i ++) {
                    $wordList [] = $arrayList[ $i ];
                }
                $words = implode ( " ", $wordList );
                $allWords = $this->readByLine ();
                $allWords [$line] = $words . "\n";
                $this->clearFile ();
                for($i = 0; $i < sizeof ( $allWords ); $i ++) {
                    $this->writeToFile ( $allWords [$i] );
                }
                return $this;
            } else {
                return $this;
            }

        } else {
            return $this;
        }
    }

    /**
     * Delete a word from file
     * @param $data - The word to delete from the file
     * @param null $line - The line to delete the word from (optional)
     * @param null $index - The index to delete the word from (optional)
     * @return $this
     */
    public function deleteFromFile($data, $line = NULL, $index = NULL) {
        if ($this->exists && $data !== null) {
            if ($line === null && $index === null) {
                $lineData = $this->readByLine ();
                $this->clearFile ();
                for($i = 0; $i < sizeof ( $lineData ); $i ++) {
                    $words = $lineData [$i];
                    $listOfWords = explode ( " ", $words );
                    for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
                        $value = strcasecmp($data, trim ($listOfWords [$y] ));
                        if ($value===0) {
                            $listOfWords [$y] = "";
                        }
                    }
                    $listOfWords = array_values ( $listOfWords );
                    $words = implode ( " ", $listOfWords );
                    if (! (preg_match('/\S/',  $words) ? false: true)) {
                        $this->writeToFile ( trim ( $words ) . "\n" );
                    }
                }
                return $this;

            } else if ($line !== null && $index === null) {
                $lineData = $this->readByLine ();
                $this->clearFile ();
                $words = $lineData [$line];
                $listOfWords = explode ( " ", $words );
                for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
                    $value = strcasecmp($data, trim ($listOfWords [$y] ));
                    if ($value===0) {
                        $listOfWords [$y] = "";
                    }
                }
                $listOfWords = array_values ( $listOfWords );
                $words = implode ( " ", $listOfWords );
                if ((preg_match('/\S/',  $words) ? false: true)) {
                    unset ( $lineData [$line] );
                    $lineData = array_values ( $lineData );
                } else {
                    $lineData [$line] = trim ( $words ) . "\n";
                }

                for($y = 0; $y < sizeof ( $lineData ); $y ++) {
                    $this->writeToFile ( $lineData [$y] );
                }
                return $this;

            } else if ($line !== null && $index !== null) {
                $wordToMove = $this->getWordByLineIndex ( $line, $index );
                $this->deleteFromFile ( $wordToMove, $line );
                return $this;
            } else {
                return $this;
            }
        } else {
            return $this;
        }
    }

    /**
     * Replace a specific word with a given data
     * @param $data - The word that will be replaced
     * @param $replacement - The replacement word.
     * @param null $line - The line to replace from (optional)
     * @param null $index - The index to replace at (optional)
     * @return $this
     */
    public function replaceWordWith($data, $replacement, $line = NULL, $index = NULL) {
        if ($this->exists && $data !== null) {
            if ($line === null && $index === null) {
                $lineData = $this->readByLine ();
                $this->clearFile ();
                for($i = 0; $i < sizeof ( $lineData ); $i ++) {
                    $words = $lineData [$i];
                    $listOfWords = explode ( " ", $words );
                    for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
                        $value = strcasecmp($data, trim ($listOfWords [$y] ));
                        if ($value===0) {
                            $listOfWords [$y] = $replacement;
                        }
                    }
                    $listOfWords = array_values ( $listOfWords );
                    $words = implode ( " ", $listOfWords );
                    $this->writeToFile ( trim ( $words ) . "\n" );
                }
                return $this;

            } else if ($line !== null && $index === null) {
                $lineData = $this->readByLine ();
                $this->clearFile ();
                $words = $lineData [$line];
                $listOfWords = explode ( " ", $words );
                for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
                    $value = strcasecmp($data, trim ($listOfWords [$y] ));
                    if ($value===0) {
                        $listOfWords [$y] = $replacement;
                    }
                }
                $listOfWords = array_values ( $listOfWords );
                $words = implode ( " ", $listOfWords );
                $lineData [$line] = trim ( $words ) . "\n";

                for($y = 0; $y < sizeof ( $lineData ); $y ++) {
                    $this->writeToFile ( $lineData [$y] );
                }
                return $this;

            } else if ($line !== null && $index !== null) {
                $wordToMove = $this->getWordByLineIndex ( $line, $index );
                $this->replaceWordWith ( $wordToMove, $replacement, $line );
                return $this;
            } else {
                return $this;
            }
        } else {
            return $this;
        }
    }

    /**
     * Replace a specific line in the file with another
     * @param $data - The replacement data
     * @param $line - The line to replace at
     * @return $this
     */
    public function replaceLineWith($data, $line) {
        if ($this->exists && $data !== null && $line !== null) {
            $lineData = $this->readByLine ();
            $this->clearFile ();
            $lineData [$line] = $data . "\n";
            for($y = 0; $y < sizeof ( $lineData ); $y ++) {
                $this->writeToFile ( $lineData [$y] );
            }
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Swap two lines in a file
     * @param $line1 - The first line to swap
     * @param $line2 - The second line to swap
     * @return $this
     */
    public function swapLines($line1, $line2) {
        if ($this->exists && $line1 !== null && $line2 !== null) {
            $lineData = $this->readByLine ();
            $inodes = array();
            for($y = 0; $y < sizeof ( $lineData ); $y ++) {
                $inodes[$y]= $lineData [$y];
            }
            $data1 = $inodes[$line1];
            $data2 = $inodes[$line2];
            $inodes[$line1] = $data2;
            $inodes[$line2] = $data1;
            $this->clearFile ();
            foreach($inodes as $key => $value){
                $this->writeToFile ( $value);
            }
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Delete a specific line from the file
     * @param $line - The line to delete
     * @return $this
     */
    public function deleteLine($line) {
        if ($this->exists && $line !== null) {
            $lineData = $this->readByLine ();

            $inodes = array();
            for($y = 0; $y < sizeof ( $lineData ); $y ++) {
                $inodes[$y] = $lineData [$y];
            }
            unset($inodes[$line]);
            array_shift($inodes);
            $this->clearFile ();
            foreach($inodes as $key => $value){
                $this->writeToFile ( $value);
            }
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Read file and return an array of words in the file
     * @return array|bool
     */
    public function readFileByWord() {
        if ($this->exists) {
            $filecontents = file_get_contents ( $this->filename );
            $words = preg_split ( '/[\s]+/', $filecontents, - 1, PREG_SPLIT_NO_EMPTY );
            return $words;
        } else {
            return false;
        }
    }

    /**
     * Split the content of the file by a specific deliminator
     * @param $spacer - The deliminator
     * @return array|bool
     */
    public function splitContentByDel($spacer) {
        $conent = $this->readToString ();
        if ($conent != false) {
            return explode ( $spacer, $conent );
        } else {
            return false;
        }
    }

    /**
     * Copy data from one file to another
     * @param $fileTo - The file to copy the data to.
     * @return $this|bool
     */
    public function copyDataTo($fileTo) {
        if ($this->exists) {
            if($fileTo instanceof File){
                $fileTo = $fileTo->getFileName();
            }
            if (file_exists ( $fileTo )) {
                $data = file ( $this->filename ) or die ( 'Error please try again!' );
                $handle = fopen ( $fileTo, "a" ) or die ('Error please try again!');
                for($i = 0; $i < $this->lines; $i ++) {
                    fwrite ( $handle, $data [$i] );
                }
                fclose ( $handle );
                return $this;

            } else {
                die ('Error please try again!');
            }
        } else {
            return $this;
        }
    }

    /**
     * Get the content of the file between two line ranges
     * @param $start - The starting line number
     * @param $end - The end line number
     * @return array|bool
     */
    public function getContentByLineRange($start, $end) {
        if ($this->exists) {
            if ($end < $start) {
                die ( "End point must be equal to or greater than starting point." );
            }
            $lineCounter = $start;
            $iarray = array ();
            while ( $lineCounter < $this->lines && $lineCounter <= $end ) {
                if ($lineCounter == $start) {
                    $iarray [] = $this->readAtLine ( $lineCounter );
                } else {
                    $iarray [] = $this->readAtLine ( $lineCounter );
                }
                $lineCounter ++;
            }
            return $iarray;

        } else {

            return false;
        }
    }

    /**
     * Copy the file to a different location
     * @param $copyLocation - The location to copy the file to.
     * @return $this
     */
    public function copyFileTo($copyLocation) {
        if (file_exists ( $copyLocation ) == true) {
            if ($this->exists) {
                copy ( $this->filename, $copyLocation . "/" . $this->filename );
                return $this;

            } else {
                return $this;
            }

        } else {return $this;}

    }

    /**
     * Move the file to a different location
     * @param $copyLocation - The location to move the file to.
     * @return $this
     */
    public function moveFileTo($copyLocation) {
        $this->copyFileTo ( $copyLocation )->deleteFile();
        return $this;
    }

    /**
     * Empty all data from the file
     * @return $this
     */
    public function clearFile() {
        if ($this->exists) {
            // create file
            $handler = fopen ( $this->filename, 'w' ) or die ( "Error please try again!" );
            $this->setMetta ();
            fclose ( $handler );
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Returns the line and index of the word being used
     * @param $value - The value to search for.
     * @return array
     */
    public function getLineAndIndex($value){
        $index =  $this->indexOfWord($value);
        $line = $this->indexOfLine($value);
        return array('line' => $line, 'index' => $index);
    }

    private function setNumLines() {
        if ($this->exists) {
            if ($fh = fopen ( $this->filename, 'r' )) {
                while ( ! feof ( $fh ) ) {
                    if (fgets ( $fh )) {
                        $this->lines ++;
                    }
                }
            }
            fclose ( $fh );
        } else
            return false;
        return false;
    }

    private function setWordCount() {
        if ($this->exists) {
            $this->wordCount = sizeof ( $this->readFileByWord () );
        } else
            return false;
        return false;
    }

    private function setFileSize() {
        if ($this->exists) {
            $this->size = filesize ( $this->filename );
        } else
            return false;
        return false;
    }

    private function setMetta() {
        $this->setWordCount ();
        $this->setNumLines ();
        $this->setFileSize ();
    }


}