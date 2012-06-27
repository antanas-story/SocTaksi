<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:33:59
         compiled from "../script/templates/web\orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:185764feac57744a655-53088880%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7c1f42bcb27313fa6a2f848d46a4eb3d4717eb1' => 
    array (
      0 => '../script/templates/web\\orders.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185764feac57744a655-53088880',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title','Užsakymai');$_template->assign('metadescrip',''); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="page">
	<h2><?php if ($_smarty_tpl->getVariable('current')->value){?>Einamieji užsakymai<?php }else{ ?>Buvę užsakymai<?php }?></h2>
	<a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
" class="button">Naujas užsakymas</a>
	<?php if ($_smarty_tpl->getVariable('current')->value){?>
	<a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
uzsakymai/istorija" class="button">Užsakymų istorija</a>
	<?php }else{ ?>
	<a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
uzsakymai" class="button">Einamieji užsakymai</a>
	<?php }?>
	<div id="orders">
	<?php $_template = new Smarty_Internal_Template('orderlist.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	</div>
</div><!-- /.page -->
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>