<?php
if(!function_exists("dump")) {
    /**
    * Var_dump extended
    * 
    * @param mixed $mixed The variable to be dumped
    * @param mixed $text The text to be displayed before the dumped var
    */
    function dump($mixed, $text="") {
        echo "<pre>";
        if(!empty($text)) { echo "<i style='color:#111198'>$text</i> "; }
        var_dump($mixed);
        echo "</pre>";
    }
}
if(!function_exists("dumpq")) {
    /**
    * Quiet dump
    * 
    * @param mixed $mixed The var to be dumped
    * @param string $text The text to be displayed near the dumped var
    */
    function dumpq($mixed=NULL, $text="") {
        if(isset($_COOKIE['full'])) {
            if(empty($mixed)) {
                if(!empty($text)) echo $text;
            } else {
                dump($mixed, $text);
            }
        }
    }
}
if(!function_exists("noConflictFile")) {
    /**
    * Returns a path which doesn't conflict
    * 
    * @param string $path Path to the file you don't want conflicting
    */
    function noConflictFile($path) {
        $dir =  dirname($path);
        $fname = basename($path);
        $extension = pathinfo($fname, PATHINFO_EXTENSION);
        $i = 0;
        do {
            $i++;
            $tmp = $i > 1 ? "_".$i : "";
            $newfname = pathinfo($fname, PATHINFO_FILENAME).$tmp.".".$extension;
            $newpath = $dir."/".$newfname;
        } while (file_exists($newpath));
        
        return $newpath;
    }        
    
}
if(!function_exists("debug")) {
    /**
    * Function shows info only to superadmin through message framework
    * 
    * @param string $str Message to display
    */
    function debug($str) {
        //if(isset($_SESSION["superadmin"])&&$_SESSION["superadmin"]==true) Admin::message($str);        
        if(isset($_SESSION["superadmin"])&&$_SESSION["superadmin"]==true)
            if(!isset($_SESSION["debug"])) $_SESSION["debug"]=$str;
            else $_SESSION["debug"] .= $str;
    }
    function debugStart() {
        ob_start();
    }
    function debugEnd() {
        $content = ob_get_contents();
        ob_end_clean();
        debug($content);
    }
    function debugDump($mixed, $text="") {
        debugStart();
        dump($mixed, $text);
        debugEnd();
    }
}

?>