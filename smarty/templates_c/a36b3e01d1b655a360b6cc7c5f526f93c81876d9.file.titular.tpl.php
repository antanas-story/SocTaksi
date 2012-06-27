<?php /* Smarty version Smarty-3.0.7, created on 2012-06-27 11:15:15
         compiled from "../script/templates/web\titular.tpl" */ ?>
<?php /*%%SmartyHeaderCode:325294feac1134b0bb1-93045199%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a36b3e01d1b655a360b6cc7c5f526f93c81876d9' => 
    array (
      0 => '../script/templates/web\\titular.tpl',
      1 => 1340576870,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '325294feac1134b0bb1-93045199',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('title','');$_template->assign('metadescrip',$_smarty_tpl->getVariable('titular')->value['metaDescription']); echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div class="about">
	<?php echo $_smarty_tpl->getVariable('titular')->value['text'];?>

</div><!-- /.about -->
<div class="rezervation">
	<h2>Socialinio taksi rezervacija</h2>
	<form action="<?php echo $_smarty_tpl->getVariable('path')->value;?>
rezervuoti" method="post" id="theform" class="<?php if (empty($_smarty_tpl->getVariable('user',null,true,false)->value)){?>unregistered<?php }?>">
		<div class="content">
			Prašau pasiimti mane iš
			<span class="input-holder">
				<label>Vieta</label>
				<input
					type="text"
					title="Gatvė bei namo numeris"
					class="input place"
					id="addressField"
					name="address" />
			</span>
			
			Šituo laiku
			<span class="input-holder">
				<label>Data</label>
				<input type="text" value="<?php echo date("Y-m-d");?>
" class="input date" id="dateField" name="date" />
				<a href="#" class="cal calendarIcon"></a>
			</span>
			<span class="input-holder">
				<label>Laikas</label>
				<input type="text" title="VV:MM" value="VV:MM" class="input time" id="timeField" name="time" />
			</span>
		</div>
		<div class="button-holder">
			<a href="#" class="help" onclick="alert('Pagalba ruošiama');return false;">Pagalba</a>
			<button type="submit">Rezervuoti</button>
			<input type="submit" style="display:none;" value="Submit" />
		</div>
	</form>
</div><!-- /.rezervation -->
	<div id="partners">
			<a href="http://www.autocity.lt" title="Autocity" target="_blank" class="autocity"></a>
			<a href="http://www.infoera.lt" title="Info era" target="_blank" class="infoera"></a>
			<a href="http://www.osfl.lt" title="OSFL PROJEKTAI" target="_blank" class="osfl"></a>
			<a href="http://www.submarinas.lt" title="Submarine" target="_blank" class="submarinas"></a>
			<a href="http://www.plaunu.lt" title="Plaunu pats" target="_blank" class="plaunu"></a>
			<a href="http://www.zmogui.lt" title="Nacionalinis socialines integracijos instituta" target="_blank" class="zmogui"></a>
	</div><!-- /#partners -->

<?php $_template = new Smarty_Internal_Template('footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>