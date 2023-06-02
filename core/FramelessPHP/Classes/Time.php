<?php

namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class iTime - This class handles time related functions
 * @package FramelessPHP\ibase
 */
class Time{
	private static $timeZone;
	public static $timePassed;

	/**
	 * Set the current timezone
	 * @param String $timeZone
	 */
	public static function setTimeZone($timeZone)
	{
		self::$timeZone = date_default_timezone_set($timeZone);
            
	}
	
	/**
	 * Return the current time or time based on given timestamp
     * @param null $timestamp
     * @return false|string
     */
	public static function getTime($timestamp=null)
	{
	    if($timestamp === null)
        {
            return date('h:i a', time());
        }else{
            return date('h:i a', $timestamp);
        }

	}
	
	/**
	 * Get the current timestamp
	 * @return the timestamp
	 */
	public static function getTimeStamp()
	{
		return time();
	}
	
	/**
	 * Get the current hour or hour from a given timestamp
     * @param null $timestamp
     * @return false|string
     */
	public static function getHour($timestamp=null)
    {
        if($timestamp === null)
        {
            return date('h', time());
        }else{
            return date('h', $timestamp);
        }

    }


    /**
	 * get the minute of the hour or timestamp provided
	 * @param null $timestamp
     * @return false|string
     */
	public static function getMin($timestamp=null)
    {
        if($timestamp === null)
        {
            return date('i', time());
        }else{
            return date('i', $timestamp);
        }

    }
	
	/**
	 * Get the seconds from the hour or timestamp provided
	 * @param null $timestamp
     * @return false|string
     */
	public static function getSec($timestamp=null)
    {
        if($timestamp === null)
        {
            return date('s', time());
        }else{
            return date('s', $timestamp);
        }

    }
	
	/**
	 * Get the time passed between two dates.
	 * @param time $startTime
	 * @param time $secondTime
	 */
	public static function timePassed($startTime,$secondTime=null)
	{
		$then = new DateTime($startTime);
		if($secondTime===null)
		{
			$now = new DateTime();	
		}else {
			$now = new DateTime($secondTime);
		}	
		self::$timePassed = $then->diff($now);
		
	}

    /**
     * Return full date time of current time or given timestamp
     * @param null $timestamp
     * @return false|string
     */
    public static function getDateTime($timestamp=null)
    {
        if($timestamp === null)
        {
            return date('r', time());
        }else{
            return date('r', $timestamp);
        }

    }








}

?>