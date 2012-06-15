<?php
require "default.php";
session_start();
$user = new User;
$user->display();
?>