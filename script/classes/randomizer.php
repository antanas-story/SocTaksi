<?php
class Randomizer {
    public static function any($number) {
        $result = "";
        for($i=0; $i<$number; $i++)
            if(mt_rand(0,1)==1) {
                $result .= Randomizer::letters(1);
            } else {
                $result .= Randomizer::numbers(1);
            }            
            
        return $result;        
    }
    public static function letters($number) {
        $result = "";
        for($i=0; $i<$number; $i++)
            $result .= chr(mt_rand(65, 90));
        return $result;
    }
    public static function numbers($number) {
        $result = "";
        for($i=0; $i<$number; $i++)
            $result .= mt_rand(0, 9);
        return $result;
    }    
}
?>
