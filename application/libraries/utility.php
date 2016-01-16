<?php

class Utility{
    function displayarray($ar, $color = "F00"){
        echo '<pre style="z-index:9999;color:#'.$color.'">';
        print_r($ar);
        echo '</pre><br style="clear:both;" /><br />';
    }

    function arrayWalk($array, $append){
        $ar = array();
        if(count($array)>0){
            foreach($array as $k=>$v){
                $ar[$k] = $append . $v;
            }
        }

        return $ar;
    }
}

