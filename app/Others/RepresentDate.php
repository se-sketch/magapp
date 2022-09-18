<?php

namespace App\Others;

class RepresentDate
{
	
	function __construct()
	{
		# code...
	}

    public static function getDateFromWeekNumber($year, $week)
    {
        $ts = strtotime(sprintf("%4dW%02d", $year, $week));

        $date = date('Y-m-d', $ts);

        /*
        $date = new DateTime('midnight'); 
        $date->setISODate($year, $week);
        */

        return $date;
    }

    public static function getRepresentWeek($year, $week)
    {
        $ts = strtotime(sprintf("%4dW%02d", $year, $week));

        $date = date('d.m', $ts);

        $date_end = date('d.m', $ts - 1 + 60*60*24 * 7);

        $str = ''.$date.' - '.$date_end;

        return $str;
    }

}