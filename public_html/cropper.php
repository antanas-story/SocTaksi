<?php
session_start();

include "default.php";
if(!isset($_SESSION['uid'])||!isset($_SESSION['admin'])) { 
    die;
}
$requiredfields = array("filename", "prefix", "y", "x", "destw", "desth", "w", "h");
$pass = true;
foreach($requiredfields as $f) {
    if(!isset($_POST[$f])) $pass = false;
}
if($pass) {
    $path = "imgs/".$_POST["filename"];
    $dest = "imgs/".$_POST["prefix"].$_POST["filename"];
    $img = new Image($path);
    //dump($_POST, 'post');
    echo $dest;
    $img->cropImage($_POST["x"], $_POST["y"], $_POST["destw"], $_POST["desth"], $_POST["w"], $_POST["h"], $dest);
    Admin::message("Nuotrauka sėmingai iškirpta.");
} else {
    Admin::error("Vidinė puslapio klaida! Nuotrauka neiškirpta.");
}
?>
