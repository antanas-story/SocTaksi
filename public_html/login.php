<?php

session_start(); 
require "default.php";

if(isset($_POST['password'])&&isset($_POST['username'])) {
    $login = new login();
    if(!$login->tryToLogin($_POST['username'], $_POST['password'])) $loginfail = true;
    else $loginfail = false;
}

if(isset($_SESSION['uid'])) {
    if(isset($_SESSION['admin'])&&$_SESSION['admin']==true) {
        header("Location: admin.php"); die;
    } else {
        header("Location: index.php"); die;
    }
}




$smarty = new MySmarty;
$smarty->template_dir = SMARTY_LOGIN_TEMPLATE_DIR;

if(isset($loginfail)&&$loginfail) 
    $smarty->assign('error', 'Blogas vartotojo vardas ir/arba slaptažodis');
elseif(isset($_GET["expired"])) {
    $smarty->assign('error', 'Sesijos laikas baigėsi, prašome prisijungti vėl');
}

$smarty->display('login.tpl');
?>
