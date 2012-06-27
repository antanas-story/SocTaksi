<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 08:25:39
         compiled from "../script/templates/login\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:139074feac383186936-96703395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61ab8aaa11db7503dcdfe44b18a3c21dd7b6eed0' => 
    array (
      0 => '../script/templates/login\\login.tpl',
      1 => 1340785537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139074feac383186936-96703395',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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
<?php if (isset($_smarty_tpl->getVariable('error',null,true,false)->value)){?>
<div class='error'><?php echo $_smarty_tpl->getVariable('error')->value;?>
</div>
<?php }?>
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