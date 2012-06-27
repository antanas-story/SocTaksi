<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:15:15
         compiled from "../script/templates/web\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:308384feac1136e7275-49204569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8563536d467eeb27ed3368af32cb468f1ed4b519' => 
    array (
      0 => '../script/templates/web\\header.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '308384feac1136e7275-49204569',
  'function' => 
  array (
    'menu' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="lt-LT"><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    <meta name="robots" content="All" />    <meta name="author" content="True Story" />    <meta name="copyright" content="Nacionalinis socialinės integracijos institutas" />    <meta name="description" content="<?php echo $_smarty_tpl->getVariable('metadescrip')->value;?>
" />	<link rel="icon" href="favicon.ico" type="image/x-icon" />	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />	<link rel="alternate" type="application/rss+xml" href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
naujienos/rss" title="RSS Socialnio Taksi Naujienos" />	<title><?php if (!empty($_smarty_tpl->getVariable('title',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('title')->value;?>
 -<?php }?>Socialinis taksi</title>	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
css/style.css" />	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
css/soctaxi-theme/jquery-ui.css" />	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.js" type="text/javascript"></script>	<script src="<?php echo $_smarty_tpl->getVariable('path')->value;?>
js/script.js"></script>	<script type="text/javascript">		  var _gaq = _gaq || [];	  _gaq.push(['_setAccount', 'UA-25045663-3']);	  _gaq.push(['_trackPageview']);		  (function() {		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);	  })();		</script></head><body><div id="wrapper">	<input type="hidden" id="path" name="path" value="<?php echo $_smarty_tpl->getVariable('path')->value;?>
" />	<div id="header">		<div class="wrap">			<h1 id="logo"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
" title="Socialinis taksi">Socialinis taksi</a></h1>			<ul id="mainMenu">			<?php if (!function_exists('smarty_template_function_menu')) {
    function smarty_template_function_menu($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['menu']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->getVariable('href')->value==$_smarty_tpl->getVariable('i')->value){?>current_page_item<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
				<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>''));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
">Pradžia</a></li>				<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"apie"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
apie">Apie projektą</a>				<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"naujienos"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
naujienos">Naujienos</a></li>				<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"registracija"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
registracija">Registracija</a></li>				<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"remejai"));?>
 last"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
remejai">Rėmėjai</a></li>			</ul><!-- /#mainMenu -->			<div id="userMenu">				<?php if (!empty($_smarty_tpl->getVariable('user',null,true,false)->value)){?>				<div class="content">					Prisijungęs kaip: <strong><?php echo $_smarty_tpl->getVariable('user')->value['firstname'];?>
 <?php echo $_smarty_tpl->getVariable('user')->value['lastname'];?>
</strong>				</div>					<ul>						<?php if ($_smarty_tpl->getVariable('user')->value['type']=="client"){?>							<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"uzsakymai"));?>
 settings"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
uzsakymai">Užsakymai</a></li>						<?php }elseif($_smarty_tpl->getVariable('user')->value['type']=="driver"){?>							<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"uzsakymai"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
uzsakymai">Užsakymai</a></li>						<?php }else{ ?>								<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"uzsakymai"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
uzsakymai">Užsakymai</a></li>							<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"statistika"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
statistika">Statistika</a></li>							<li class="<?php smarty_template_function_menu($_smarty_tpl,array('i'=>"vartotojai"));?>
"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
vartotojai">Vartotojai</a></li>						<?php }?>						<li class="logout"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
logout">Atsijungti</a></li>					</ul>				<?php }else{ ?>					<div class="content">						Šiuo metu esate neprisijungęs					</div>					<ul>						<li><a href="#" id="login">Prisijungti</a></li>					</ul>								<?php }?>			</div><!-- /#userMenu -->		</div><!-- /.wrap -->	</div><!-- /#header -->	<div id="mainSlot">