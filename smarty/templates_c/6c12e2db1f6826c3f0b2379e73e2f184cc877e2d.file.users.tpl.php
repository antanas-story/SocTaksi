<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:35:48
         compiled from "../script/templates/web\users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:239964feac5e4a35412-70135931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c12e2db1f6826c3f0b2379e73e2f184cc877e2d' => 
    array (
      0 => '../script/templates/web\\users.tpl',
      1 => 1340786147,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239964feac5e4a35412-70135931',
  'function' => 
  array (
    'users' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title','Vartotojai');$_template->assign('metadescrip',''); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php if (!function_exists('smarty_template_function_users')) {
    function smarty_template_function_users($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['users']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if (!empty($_smarty_tpl->getVariable('list',null,true,false)->value)){?>
	<ul class="users-list">
	<?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
?>
		<li>
			<div class="name">
				<?php echo $_smarty_tpl->tpl_vars['u']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['u']->value['lastname'];?>
<?php if (!empty($_smarty_tpl->tpl_vars['u']->value['contract'])){?> <span>(Sutarties numeris: <?php echo $_smarty_tpl->tpl_vars['u']->value['contract'];?>
)<?php }?></span><?php if (!empty($_smarty_tpl->tpl_vars['u']->value['phone'])){?>, telefonas: <span><?php echo $_smarty_tpl->tpl_vars['u']->value['phone'];?>
</span><?php }?>
			</div>
			<?php if (!empty($_smarty_tpl->tpl_vars['u']->value['address'])){?>
			<div class="adress"><span>Adresas:</span> <?php echo $_smarty_tpl->tpl_vars['u']->value['address'];?>
</div>
			<?php }?>
			<div class="adress"><span>El. pašto adresas:</span> <?php echo $_smarty_tpl->tpl_vars['u']->value['email'];?>
</div>
			<div class="count">
				<?php if ($_smarty_tpl->tpl_vars['u']->value['type']!='client'){?>Priėmė iškvietimą<?php }else{ ?>Kvietė mašina<?php }?>
				<strong><?php echo $_smarty_tpl->tpl_vars['u']->value['count'];?>
</strong> kart<?php if (($_smarty_tpl->tpl_vars['u']->value['count']%100>=11&&$_smarty_tpl->tpl_vars['u']->value['count']%100<=19)||$_smarty_tpl->tpl_vars['u']->value['count']%10==0){?>ų<?php }elseif($_smarty_tpl->tpl_vars['u']->value['count']%10==1){?>ą<?php }else{ ?>us<?php }?>
			</div>
			<?php if (!empty($_smarty_tpl->tpl_vars['u']->value['extra'])){?>
			<div class="more"><span>Papildoma informacija:</span> <?php echo $_smarty_tpl->tpl_vars['u']->value['extra'];?>
</div>
			<?php }?>
			<div class="buttons"><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
vartotojai/keisti/<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
">Redaguoti</a>
			<?php if ($_smarty_tpl->tpl_vars['u']->value['type']!='admin'){?><a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
vartotojai/trinti/<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
">Trinti</a><?php }?>
			 </div>
		</li>
	<?php }} ?>
	</ul>
<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="page">
	<h2>Vartotojai</h2>
	<a href="<?php echo $_smarty_tpl->getVariable('path')->value;?>
vartotojai/kurti" class="button">Sukurti naują vartotoją</a>
	
	
	<h3 style="clear:left">Klientai</h3>
	<?php smarty_template_function_users($_smarty_tpl,array('list'=>$_smarty_tpl->getVariable('clients')->value));?>

	
	<h3>Vairuotojai</h3>
	<?php smarty_template_function_users($_smarty_tpl,array('list'=>$_smarty_tpl->getVariable('drivers')->value));?>

	
	<h3>Administratoriai</h3>
	<?php smarty_template_function_users($_smarty_tpl,array('list'=>$_smarty_tpl->getVariable('admins')->value));?>

	
	
</div><!-- /.page -->
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>