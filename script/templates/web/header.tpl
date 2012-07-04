<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="lt-LT"><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    <meta name="robots" content="All" />    <meta name="author" content="True Story" />    <meta name="copyright" content="Nacionalinis socialinės integracijos institutas" />    <meta name="description" content="{$metadescrip}" />	<link rel="icon" href="favicon.ico" type="image/x-icon" />	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />	<link rel="alternate" type="application/rss+xml" href="{$path}naujienos/rss" title="RSS Socialnio Taksi Naujienos" />	<title>{if !empty($title)}{$title} -{/if}Socialinis taksi</title>	<link rel="stylesheet" type="text/css" media="all" href="{$path}css/style.css" />	<link rel="stylesheet" type="text/css" media="all" href="{$path}css/soctaxi-theme/jquery-ui.css" />	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.js" type="text/javascript"></script>	{*<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDOntoMB2nYDBpFgUOzc6Dett1VnZJ0Eqo" type="text/javascript"></script>*}	<script src="{$path}js/script.js"></script>	<script type="text/javascript">		  var _gaq = _gaq || [];	  _gaq.push(['_setAccount', 'UA-25045663-3']);	  _gaq.push(['_trackPageview']);		  (function() {		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);	  })();		</script></head><body><div id="wrapper">	<input type="hidden" id="path" name="path" value="{$path}" />	<input type="hidden" id="minutesPerOrder" name="minutesPerOrder" value="{$minutesPerOrder}" />	<div id="header">		<div class="wrap">			<h1 id="logo"><a href="{$path}" title="Socialinis taksi">Socialinis taksi</a></h1>			<ul id="mainMenu">			{function menu}{if $href==$i}current_page_item{/if}{/function}				<li class="{menu i=""}"><a href="{$path}">Pradžia</a></li>				<li class="{menu i="apie"}"><a href="{$path}apie">Apie projektą</a>				<li class="{menu i="naujienos"}"><a href="{$path}naujienos">Naujienos</a></li>				<li class="{menu i="registracija"}"><a href="{$path}registracija">Registracija</a></li>				<li class="{menu i="remejai"} last"><a href="{$path}remejai">Rėmėjai</a></li>			</ul><!-- /#mainMenu -->			<div id="userMenu">				{if !empty($user)}				<div class="content">					Prisijungęs kaip: <strong>{$user.firstname} {$user.lastname}</strong>				</div>					<ul>						{if $user.type=="client"}							<li class="{menu i="uzsakymai"} settings"><a href="{$path}uzsakymai">Užsakymai</a></li>						{elseif $user.type=="driver"}							<li class="{menu i="uzsakymai"}"><a href="{$path}uzsakymai">Užsakymai</a></li>						{else}								<li class="{menu i="uzsakymai"}"><a href="{$path}uzsakymai">Užsakymai</a></li>							<li class="{menu i="statistika"}"><a href="{$path}statistika">Statistika</a></li>							<li class="{menu i="vartotojai"}"><a href="{$path}vartotojai">Vartotojai</a></li>						{/if}						<li class="logout"><a href="{$path}logout">Atsijungti</a></li>					</ul>				{else}					<div class="content">						Šiuo metu esate neprisijungęs					</div>					<ul>						<li><a href="#" id="login">Prisijungti</a></li>					</ul>								{/if}			</div><!-- /#userMenu -->		</div><!-- /.wrap -->	</div><!-- /#header -->	<div id="mainSlot">