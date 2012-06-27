<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:34:01
         compiled from "../script/templates/web\statistics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:311184feac579407a89-44508990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4dc9a7a77bdb266a041df7f4b46cc36acf5db635' => 
    array (
      0 => '../script/templates/web\\statistics.tpl',
      1 => 1340575729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '311184feac579407a89-44508990',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title','Statistika');$_template->assign('metadescrip',''); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<div class="page">
	<h2>Statistika</h2>
	
	<div id="stats">
		<div>Vartotojų: <strong><?php echo $_smarty_tpl->getVariable('totalUsers')->value;?>
</strong></div>
		<div>Vienas vartotojas vidutiniškai padaro <strong><?php echo round($_smarty_tpl->getVariable('ordersPerMonthPerUser')->value,2);?>
</strong> užsakymų į mėnesį</div>
		<div>
			Iš viso užsakymų: <strong><?php echo array_sum($_smarty_tpl->getVariable('orders')->value);?>
</strong>.
			Iš jų patvirtinta: <strong><?php echo $_smarty_tpl->getVariable('orders')->value['accepted'];?>
</strong>,
			atšaukta: <strong><?php echo $_smarty_tpl->getVariable('orders')->value['rejected'];?>
</strong>,
			neapdorota: <strong><?php echo $_smarty_tpl->getVariable('orders')->value['new'];?>
</strong>
		</div>
		<div title='Dar neįvykę, bet užsakyti. Statusas - neapdoroti ir patvirtinti'>
			Einamųjų užsakymų: <strong><?php echo $_smarty_tpl->getVariable('ongoingOrders')->value;?>
</strong>
		</div>
		<?php $_smarty_tpl->tpl_vars['ordersInMinutes'] = new Smarty_variable(30*$_smarty_tpl->getVariable('orders')->value['accepted'], null, null);?>
		<?php $_smarty_tpl->tpl_vars['ordersInHours'] = new Smarty_variable(floor(($_smarty_tpl->getVariable('ordersInMinutes')->value/60)), null, null);?>
		<div>Bendras priimtų užsakymų laikas: <strong> <?php echo $_smarty_tpl->getVariable('ordersInHours')->value;?>
 val. <?php echo $_smarty_tpl->getVariable('ordersInMinutes')->value-$_smarty_tpl->getVariable('ordersInHours')->value*60;?>
 min.</strong></div>
		<div title='Skaičiuojama nuo 2012-06-01'>
			Užsakymų/diena: <strong><?php echo round($_smarty_tpl->getVariable('ordersPerDay')->value,2);?>
</strong>
		</div>
	</div>
</div><!-- /.page -->
<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>