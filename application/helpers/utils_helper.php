<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('DisplayArray'))
{
    function DisplayArray($ar, $color = "F00"){
        echo '<pre style="z-index:9999;color:#'.$color.'">';
        print_r($ar);
        echo '</pre><br style="clear:both;" /><br />';
    }
}

if ( ! function_exists('ArrayWalk'))
{
    function ArrayWalk($array, $append){
        $ar = array();
        if(count($array)>0){
            foreach($array as $k=>$v){
                $ar[$k] = $append . $v;
            }
        }

        return $ar;
    }
}

if(! function_exists('CountMonths'))
{
    function CountMonths($currentDate, $laterDate)
    {
        $d1 = new DateTime($currentDate);
        $d2 = new DateTime($laterDate);

        return var_export(($d1->diff($d2)->m + ($d1->diff($d2)->y*12)), true); // returns an integer
    }
}
if(! function_exists('CountYears'))
{
    function CountYears($currentDate, $laterDate)
    {
        $d1 = new DateTime($currentDate);
        $d2 = new DateTime($laterDate);

        $diff = $d2->diff($d1);

        return $diff->y;
    }
}
if(! function_exists('CountDays'))
{
    function CountDays($currentDate, $laterDate)
    {
        $start = strtotime('2013-03-28');
        $end = strtotime('2013-04-01');

        $days_between = ceil(abs($end - $start) / 86400);

        return $days_between;
    }
}

if(! function_exists('ValidateDate'))
{
    function ValidateDate($date,$format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

