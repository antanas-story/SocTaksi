<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="lt" xml:lang="lt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Antanas Sinica" />
    <meta name="copyright" content="Antanas Sinica" />
    <meta name="description" content="cicerone.lt administratoriaus panelė" />
    <link rel="shortcut icon" href="favicon-admin.ico">
    <link type="text/css" rel="stylesheet" href="css/theme/jquery-ui.css" />
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
    {*<link type="text/css" rel="stylesheet" href="css/fileuploader.css" />*}
    <link type="text/css" rel="stylesheet" href="css/admin.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
<!--    <script type="text/javascript" src="js/cleditor/jquery.cleditor.min.js"></script>
    <link type="text/css" rel="stylesheet" href="js/cleditor/jquery.cleditor.css" />-->
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.notify.js"></script>
    <script type="text/javascript" src="js/jquery.center.js"></script>
    <script type="text/javascript" src="js/jquery.Jcrop.js"></script>
    <script type="text/javascript" src="js/fileuploader.js"></script>
    <script type="text/javascript" src="js/admin.core.js"></script>
    <script type="text/javascript" src="js/admin.custom.js"></script>
    <title>socialinistaksi.lt admin panelė</title>
</head>
<body>
<div id="container">
    <div id="header">
        socialinistaksi.lt valdymo panelė
    </div>
    <div id="menu">
        <!--<p class="header">Meniu</p> -->
        <ul>                       
        <li><a href="admin.php" id="home" class="selected">Pradžia</a></li>
        {if $session.privs==5}{/if}
        <li><a href="admin.php?p=content">Statinis turinys</a></li>
        <li><a href="admin.php?p=news">Naujienos</a></li>
        <li><a href="" class="wip">Vairuotojai</a></li>
        <li><a href="" class="wip">Vartotojai</a></li>
        <li><a href="logout.php" class="space">Baigti darbą</a></li>
        <!--<li class="caption"><a class="expand">Nustatymai</a>
            <ul>
            <li><a href="admin.php?p=categories">Nuotraukų kategorijos</a></li>
            </ul>
        </li> -->
        {if $superadmin}
        	<li class="superadmin"><a href="">Super admin'o įrankiai</a>
            <a href="admin.php?p=admins">Administratoriai</a>
            <a href="dbtool.php" target="_blank">DB Tool</a></li>
            {*<li class="caption"><a class="expand">Super admin</a>
                <ul>                  
                <li><a href="admin.php?p=users">Vartotojai</a></li>
                <li><a href="admin.php?p=tools">Admin įrankiai</a></li>
                <li><a href="admin.php?p=content">Turinys</a></li>
                <li><a href="dbtool.php" target="_blank">DB Tool</a></li>
                </ul>
            </li>
            <li><a href="admin.php?p=content&edit=1">Apie</a></li>*}
        {/if}
        </ul>    
    </div>
    <div id="main">
        <noscript>
<div class='inlineerror ui-state-error'><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Sistemos klaida!</b> Mes neaptikome JavaScript palaikymo jūsų naršyklėje. Įjunkite JavaScript, kad naudotumėtės šia sistema be problemų.</div>        
        </noscript>
        <div id="pageerror" class='hidden inlineerror ui-state-error'><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Puslapio klaida!</b> Jeigu pamatėte šį puslapį, nukopijuokite jo turinį ir siųskite adresu admin@dailycard.lt</div>
    {if isset($location)}
        <p id="location">
            Šiuo metu naršote:
            {foreach from=$location item=place name=loc}
                <a href="{$place.url}">{$place.name|ucfirst}</a>
                {if not $smarty.foreach.loc.last}&raquo;{/if}
            {foreachelse}
                Pradžios puslapis
            {/foreach}
        </p>
    {/if}
        <div id="content">