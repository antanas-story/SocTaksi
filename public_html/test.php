<?php
echo "HELLO world<br />".getcwd(); die;
//mb_internal_encoding("UTF-8");
/* Display current internal character encoding */
  
session_start();
//header("Content-Type: text/html; charset=UTF-8");
include "default.php";

?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>


<?php
$db= new db();
$db->query("SET NAMES 'utf8'");

$db->q("INSERT INTO {p}users (username, password) VALUES ('1ąčęė', '123')");
$a = "ąčęėįš";
dump($a);

$data = $db->q("SELECT * FROM {p}users ");
dump($data);
$charsets = $db->q("show variables like 'character_set%'");
dump($charsets);
echo mb_internal_encoding();

?>
</body>
</html>
