<?php
session_start();
if(!isset($_SESSION['uid'])||!isset($_SESSION['superadmin'])||!$_SESSION['superadmin']) {
    header("Location: login.php"); die;
}

require 'default.php';
require_once ROOT.'/configs/mysql_info.php';
    $prefix = &$mysql["prefix"];
require_once ROOT.'/tables.php';

function createTables() {
    global $error, $success, $query, $mysql;
    $prefix = &$mysql["prefix"];
    if (!$mysqli = @new mysqli($mysql["host"], $mysql["user"], $mysql["password"])) {
        $error[] = "On connecting. Errno $mysqli->connect_errno: $mysqli->connect_error";
        return false;    
    }
    
    if (!@$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$mysql["database"])) {
        $error[] = "On creating database. Errno $mysqli->errno: $mysqli->error";
        return false;    
    }
    
    if (!@$mysqli->select_db($mysql["database"])) {
        $error[] = "On selecting database. Errno $mysqli->errno: $mysqli->error";
        return false; 
    }
    
    if(isset($_GET['custom'])) {
        if(!empty($_POST['query'])) {
            if (!@$mysqli->query($_POST['query'])) {
                $error[] = "When running query <span class='query'>{$_POST['query']}</span>. Errno $mysqli->errno: $mysqli->error";
                return false;
            } else {
                $success[] = "Query <span class='query'>{$_POST['query']}</span> successfully executed. Rows affected ".$mysqli->affected_rows.".";
            }
        }
    } else {
        if(isset($_GET['repair'])) {
            $table_name = $_GET['repair'];
            if(isset($query[$table_name])) {
                @$mysqli->query("DROP TABLE `$table_name`");
                if (!@$mysqli->query($query[$table_name])) {
                    $error[] = "When creating table `$table_name`. Errno $mysqli->errno: $mysqli->error";
                    return false;
                } else {
                    $success[] = "Table `$table_name` repaired.";
                }
            } else {
                $error[] = "Table $table_name could not be repaired because there is no such table";
            }
        } else {
            foreach ($query as $key => $q) {
                if(isset($_GET['drop'])) {
                    @$mysqli->query("DROP TABLE `$key`");
                }
                if (!@$mysqli->query($q)) {
                    $error[] = "When creating table `$key`. Errno $mysqli->errno: $mysqli->error";
                } else {
                    $success[] = "Table `$key` created.";
                }
            }
        }
    }
    @$mysqli->close();    
}
function writeMsgs($array) {
    echo "<ol>";
    foreach($array as $key=>$val) {
        echo "<li>$val</li>";
    }
    echo "</ol>";    
}
if( isset($_GET['create'])||isset($_GET['drop'])||isset($_GET['repair'])||isset($_GET['custom']) ) {
    createTables();
}
?>
<html>
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
 <title>Little DB Helper Tool</title>
 <style type="text/css">
body, td { text-align: center; font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: #1E1E1E; }
body { background-color:#F3F3F3; }
form textarea { width:500px; height:100px; }
#query { margin:20px 0; }

.query { color:#0000DD; }
.content { text-align:left; margin:5% auto; width:600px; padding:20px; border:1px solid #888888; background-color: #FFFFFF; }
.error { padding:5px; margin-bottom:10px; background-color:#FF6161; border:1px solid #DD2222; }
.success { padding:5px; margin-bottom:10px; background-color:#FFFFFF; border:1px solid #11CC22; }
.hint { margin:0; padding:0; margin-top:15px; font-size:10px; }
.right { text-align:right; }
.left, td { text-align:left; }
.center { text-align:center; }
.block { display:block; }
</style>
</head>
<body>
<div class="content">
<?php
if(isset($error)) {
    echo "<div class='error'>";
    writeMsgs($error);
    echo "</div>";
    unset($error);
}
if(isset($success)) {
    echo "<div class='success'>";
    writeMsgs($success);
    echo "</div>";
    unset($success);
}
 ?>
    Create tables <a href="?create">without dropping them</a>/
    <a href="?drop">dropping them</a>
    <table>
 <?php
    foreach($query as $key=>$val) {
    ?><tr><td><?php echo $key; ?></td><td><a href="?repair=<?php echo $key; ?>">repair</a></td></tr><?php
    }
 ?>
    </table>
    <div id='query'>
        You can also perform a custom query
        <form action='?custom' method='post'>
            <textarea name='query'><?php if(isset($_POST['query'])) echo $_POST['query']; ?></textarea>
            <input class='block' type='submit' value='Run query' />
        </form>
    </div>
    <p class='hint'><a href="?">refresh</a></p>
</div>
</body>
</html>