<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="lt" xml:lang="lt">
<head>
 <meta name="author" content="Antanas Sinica" />
 <meta name="copyright" content="Antanas Sinica" />
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
 <link rel="shortcut icon" href="favicon-admin.ico">
 <title>Prisijungimas</title>
 <link type="text/css" rel="stylesheet" href="css/login.css" />
</head>
<body>
<div class="password">
{if isset($error)}
<div class='error'>{$error}</div>
{/if}
<form enctype="multipart/form-data" action="login.php" method="post">
    <table>
        <tr><td class="right">Vartotojo vardas:</td><td class="left"><input id="username" type="text" name="username" /></td></tr>
        <tr><td class="right">Slaptažodis:</td><td class="left"><input id="password" type="password" name="password" /></td></tr>
        <tr><td colspan="2" class="center"><input id="submit" type="submit" value="Login" /></td></tr>
    </table>
</form>    
</div>
</body>
</html>