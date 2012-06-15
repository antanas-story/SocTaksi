<?php                
error_reporting(E_ALL); 

session_start();
require_once 'default.php';

$admin = new Admin;
if(isset($_GET['ajax'])) {
    if(isset($_GET['messages'])) {
        $admin->messages();
    } elseif(isset($_GET['custom'])) {
        $admin->customAjax($_GET, $_POST);
    } else {
        $admin->handlePost(false);
        $admin->display(true);
    }
} else {
    $admin->handlePost();
    $admin->display();
}

?>