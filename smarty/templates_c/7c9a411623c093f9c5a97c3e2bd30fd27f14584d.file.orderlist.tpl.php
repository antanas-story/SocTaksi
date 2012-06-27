<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:33:59
         compiled from "../script/templates/web\orderlist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:300894feac5774e9e58-50635376%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c9a411623c093f9c5a97c3e2bd30fd27f14584d' => 
    array (
      0 => '../script/templates/web\\orderlist.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '300894feac5774e9e58-50635376',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'D:\Work\SocTaksi\smarty\libs\plugins\modifier.date_format.php';
?>	<ul class="order-list <?php if (!$_smarty_tpl->getVariable('current')->value){?>previous-orders<?php }?>">
	<?php  $_smarty_tpl->tpl_vars['o'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('orders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['o']->key => $_smarty_tpl->tpl_vars['o']->value){
?>
		<li data-id="<?php echo $_smarty_tpl->tpl_vars['o']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['o']->value['status'];?>
">
			<div class="adress">
				<div><span>Iš:</span> <?php echo $_smarty_tpl->tpl_vars['o']->value['addressFrom'];?>
</div>
				<div><span>Į:</span> <?php echo $_smarty_tpl->tpl_vars['o']->value['addressTo'];?>
</div>
				<div><span>Data:</span> <?php echo substr($_smarty_tpl->tpl_vars['o']->value['when'],0,10);?>
, <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['o']->value['when'],"%A");?>
</div>
				<div><span>Laikas:</span> <?php echo substr($_smarty_tpl->tpl_vars['o']->value['when'],11,-3);?>
</div>
				<?php if (smarty_timestamp($_smarty_tpl->tpl_vars['o']->value['backOn'])>0){?>
				<div><span>Grįžta:</span> <?php echo substr($_smarty_tpl->tpl_vars['o']->value['backOn'],11,-3);?>
</div>
				<?php }?>
			</div>
			<div class="more">
				<strong><?php echo $_smarty_tpl->tpl_vars['o']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['o']->value['lastname'];?>
</strong>, <span>sutarties numeris:</span> <?php echo $_smarty_tpl->tpl_vars['o']->value['contract'];?>
, <span>telefonas</span> <?php echo $_smarty_tpl->tpl_vars['o']->value['phone'];?>
<br>
			<?php if (!empty($_smarty_tpl->tpl_vars['o']->value['extra'])){?>
				<span>Papildoma informacija:</span> <?php echo $_smarty_tpl->tpl_vars['o']->value['extra'];?>
</span>
			<?php }?>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['o']->value['status']=="new"){?>
				<div class="status">Užsakymas laukia patvirtinimo</div>
				<div class="buttons"><a href="#" name="accepted">Patvirtinti</a><a href="#" name="rejected">Atšaukti</a></div>
			<?php }elseif($_smarty_tpl->tpl_vars['o']->value['status']=="rejected"){?>
				<div class="status false">Užsakymas atšauktas</div>
				<div class="buttons"><a href="#" name="accepted">Patvirtinti</a></div>
			<?php }elseif($_smarty_tpl->tpl_vars['o']->value['status']=="accepted"){?>
				<div class="status true">Užsakymas patvirtintas</div>			
				<div class="buttons"><a href="#" name="rejected">Atšaukti</a></div>
			<?php }?>
		</li>
	<?php }} else { ?>
		<li>
			Užsakymų nėra.
		</li>
	<?php } ?>
	</ul>