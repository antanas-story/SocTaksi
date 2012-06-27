<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:33:42
         compiled from "../script/templates/web\news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:305474feac566c361d5-09339667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f87f67ed217745d225dd3f563eade6116ea3ce1' => 
    array (
      0 => '../script/templates/web\\news.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '305474feac566c361d5-09339667',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title','Naujienos');$_template->assign('metadescrip','Socalinio taksi naujienų puslapyje visada rasite aktualiausias naujienas apie socialinio taksi paslaugą.'); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="page">
	<h2>Naujienos</h2>
	<?php  $_smarty_tpl->tpl_vars['n'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('news')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['n']->key => $_smarty_tpl->tpl_vars['n']->value){
?>
		<?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(($_smarty_tpl->getVariable('path')->value)."naujienos/".($_smarty_tpl->tpl_vars['n']->value['slug']), null, null);?>
			<div class="box">
			<a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
"><img src="<?php echo $_smarty_tpl->getVariable('path')->value;?>
<?php echo @IMAGE_UPLOAD_DIR;?>
/t-<?php echo $_smarty_tpl->tpl_vars['n']->value['logo'];?>
" width="211" height="148"></a>
				<div class="content">
					<div class="date"><?php echo substr($_smarty_tpl->tpl_vars['n']->value['publishFrom'],0,10);?>
</div>
					<h3><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
"><?php echo $_smarty_tpl->tpl_vars['n']->value['title'];?>
</a></h3>
					<?php echo $_smarty_tpl->tpl_vars['n']->value['descriptionshort'];?>

				</div>
			</div><!-- /.box -->
	
	<?php }} ?>		
</div><!-- /.page -->
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>