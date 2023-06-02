<?php
namespace FramelessPHP\ibase;

/**
 * @version 1.0<br>
 * Class Date - This class handles dates
 * @package FramelessPHP\ibase
 */
class Date {
	

    /**
     * Return the date.
     * @param $options:
     * an associative array with options
     *  array('date' => 'current', 'numeric'=>false or true, 'format' => 'm-d-y' or any sequence of this)
     * or
     *  array('date' => whatever_date, 'numeric'=>false or  true, 'format' => 'y-m-d' or any sequence of this)
     *You can also send no param and allow the default date format to be returned.
     *
     * @return false|string
     */
	public static function getDate($options = array('date' => 'current', 'numeric'=>true, 'format' => 'm-d-y'))
    {
        if(!isset($options['date']))
        {
            $options['date'] = 'current';
        }
        if(!isset($options['numeric']))
        {
            $options['numeric'] = true;
        }
        if(!isset($options['format']))
        {
            $options['format'] = 'm-d-y';
        }

        $date = $options['date'];
        $numeric = $options['numeric'];
        $format = $options['format'];
        if ($date == 'current') {
            if ($numeric == true) {
                return date($format);
            } else {
                $format_split = explode('-', $format);
                $a = getdate();
                switch ($format_split[0]) {
                    case 'm':
                        $format_split[0] = 'month';
                        break;
                    case 'd':
                        $format_split[0] = 'mday';
                        break;
                    case 'y':
                        $format_split[0] = 'year';
                        break;
                    default:
                }
                switch ($format_split[1]) {
                    case 'm':
                        $format_split[1] = 'month';
                        break;
                    case 'd':
                        $format_split[1] = 'mday';
                        break;
                    case 'y':
                        $format_split[1] = 'year';
                        break;
                    default:
                }
                switch ($format_split[2]) {
                    case 'm':
                        $format_split[2] = 'month';
                        break;
                    case 'd':
                        $format_split[2] = 'mday';
                        break;
                    case 'y':
                        $format_split[2] = 'year';
                        break;
                    default:
                }
                return $a[$format_split[0]] . " " . $a[$format_split[1]] . ", " . $a[$format_split[2]];
            }
        } else {
            if ($numeric == true) {
                return date($format, $date);
            } else {
                $format_split = explode('-', $format);
                $a = getdate($date);
                switch ($format_split[0]) {
                    case 'm':
                        $format_split[0] = 'month';
                        break;
                    case 'd':
                        $format_split[0] = 'mday';
                        break;
                    case 'y':
                        $format_split[0] = 'year';
                        break;
                    default:
                }
                switch ($format_split[1]) {
                    case 'm':
                        $format_split[1] = 'month';
                        break;
                    case 'd':
                        $format_split[1] = 'mday';
                        break;
                    case 'y':
                        $format_split[1] = 'year';
                        break;
                    default:
                }
                switch ($format_split[2]) {
                    case 'm':
                        $format_split[2] = 'month';
                        break;
                    case 'd':
                        $format_split[2] = 'mday';
                        break;
                    case 'y':
                        $format_split[2] = 'year';
                        break;
                    default:
                }
                return $a[$format_split[0]] . " " . $a[$format_split[1]] . ", " . $a[$format_split[2]];
            }
        }
    }

	/**
	 * Get current year or year from a given timestamp/date
     * @param $date: the date to check. If left blank, will check for current date.
     * @return false|string
     */
	public static function getYear($date = null)
	{
        if($date === null)
        {
            return date("Y");
        }
        return date("Y",$date);
	}
	
	/**
	 * Get current month or month of date/timestamp provided
	 * @param array $options: array of conditions to check
     * @return false|string
     */
	public static function getMonth($options = array('date' => 'current', 'numeric' => true))
	{

        if(!isset($options['date']))
        {
            $options['date'] = 'current';
        }
        if(!isset($options['numeric']))
        {
            $options['numeric'] = true;
        }
        if($options['date'] == 'current')
        {
            if($options['numeric'] == true)
            {
                return date("m");
            }else{

                return getdate()['month'];
            }
        }else
        {
            if($options['numeric'] == true)
            {
                return date("m", $options['date']);
            }else{
                return getdate($options['date'])['month'];
            }
        }
    }

    /**
     * Get current day or day of time stamp provided
     * @param array $options
     * @return false|string
     */
    public static function getDay($options = array('date' => 'current', 'numeric' => true))
    {
        if(!isset($options['date']))
        {
            $options['date'] = 'current';
        }
        if(!isset($options['numeric']))
        {
            $options['numeric'] = true;
        }
        if($options['date'] == 'current')
        {
            if($options['numeric'] == true)
            {
                return date("d");
            }else{

                return date('l',time());
            }
        }else
        {
            if($options['numeric'] == true)
            {
                return date("d", $options['date']);
            }else{
                return date('l',$options['date']);
            }
        }

    }
	
	/**
	 * Check if a specific date is greater than another
	 * @param unknown_type $date1
	 * @param unknown_type $date2
     * @return bool
     */
	public static function dateGreater($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		if($timestamp1 > $timestamp2){
		   return true;
		}else 
		{
			return false;
		}
	}
	
	/**
	 * Check if two dates are equal
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 * @return bool
     */
	public static function datesEqual($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		if($timestamp1 == $timestamp2){
			return true;
		}else
		{
			return false;
		}
	}
	
	/**
	 * Check if current date is within a range of dates
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
     * @return bool
     */
	public static function inDateRange($startDate, $endDate)
	{
		if(self::datesEqual($startDate, $endDate) || self::dateGreater($endDate, $startDate))
		{
			return true;			
		}else
		{
			return false;
		}
	}
	
	/**
	 * Check if current date in date range
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
	 * @return bool
     */
	public static function todayInDateRange($startDate, $endDate)
	{
		if(self::datesEqual($startDate, $endDate) || self::dateGreater($endDate, $startDate))
		{
			if(self::datesEqual(self::getDate(), $startDate) || self::dateGreater(self::getDate(),$startDate))
			{
				if(self::datesEqual(self::getDate(), $endDate) || self::dateGreater($endDate,self::getDate()))
				{
					return true;	
				}else
				{
					return false;
				}
			}else
			{
				return false;
			}
		}else
		{
			return false;
		}
	}
	
	
	/**
	 * Check days passed between two dates
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 * @return number
	 */
	public static function daysPassed($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		$datediff = $timestamp1 - $timestamp2;
		return floor($datediff/(60*60*24));
    }
    
    
    /**
     * Return years and months passed between two dates
     * @param unknown_type $date1
     * @param unknown_type $date2
     * @return array
     */
   public static function yearsMonthsPassed ( $date1, $date2 )
   {
    
    	$d1 = new DateTime( $date1 );
    	$d2 = new DateTime( $date2 );
    
    	$diff = $d2->diff( $d1 );
    
    	// Return array years and months
    	return array ( $diff->y,  $diff->m );
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