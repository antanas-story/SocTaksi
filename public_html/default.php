<?php
header("Content-Type: text/html; charset=UTF-8");
mb_internal_encoding("UTF-8");

if(file_exists("../script/DEV"))
	define("CONFIG_FOLDER", 'configs-dev');
else
	define("CONFIG_FOLDER", 'configs');
require('../script/'.CONFIG_FOLDER.'/definitions.php');
require(ROOT.'/helper.php');
function autoload($className) {
    $folders = array("classes", "model", "controller");
    $done = false; $i = 0;
    while(!$done) {
        if(isset($folders[$i])) {
            $fn = ROOT."/".$folders[$i]."/".strtolower($className).".php";
            if(file_exists($fn)) {
                require_once $fn;
                $done = true;
            }      
        } else {
            $done = true;
            //die("No class '{$className}' found");
        }
        $i++;
    }
}
spl_autoload_register('autoload');

?>