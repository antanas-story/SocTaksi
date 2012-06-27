<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:33:41
         compiled from "../script/templates/web\simple.tpl" */ ?>
<?php /*%%SmartyHeaderCode:95204feac56509f347-18918200%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '920c8a7472d37ca332fbbd607992bd9ccc3a985a' => 
    array (
      0 => '../script/templates/web\\simple.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '95204feac56509f347-18918200',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title',$_smarty_tpl->getVariable('page')->value['name']);$_template->assign('metadescrip',$_smarty_tpl->getVariable('page')->value['metaDescription']); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="page">
	<?php echo $_smarty_tpl->getVariable('page')->value['text'];?>

</div><!-- /.page -->
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>