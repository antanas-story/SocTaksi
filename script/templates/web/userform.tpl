{include file='header.tpl' title=$page.name metadescrip=$page.metaDescription}
<div class="page">
	<h2>{if empty($data)}Naujo vartotojo sukūrimas{else}Informacijos apie vartotoją redagavimas{/if}</h2>
<form action="{$path}vartotojai" method="post" id="theform">
	{if !empty($data)}
	<input type='hidden' name='u[id]' value='{$data.id}' />
	{/if} 
	<table class="form" cellpadding="0" cellspacing="0">
		<tr>
			<td>Vardas</td>
			<td><input type="text" class="input" name="u[firstname]" value="{$data.firstname}"></td>
		</tr>
		<tr>
			<td>Pavardė</td>
			<td><input type="text" class="input" name="u[lastname]" value="{$data.lastname}"></td>
		</tr>
		<tr>
			<td>El-paštas</td>
			<td><input type="text" class="input" name="u[email]" value="{$data.email}"></td>
		</tr>
		<tr>
			<td>Telefonas</td>
			<td><input type="text" class="input" name="u[phone]" value="{$data.phone}"></td>
		</tr>
		<tr>
			<td>Rolė</td>
			<td>
				<input type="radio"  name="u[type]" value="client" {if $data.type=='client'}checked="checked"{/if}> Klientas<br>
				<input type="radio"  name="u[type]" value="driver" {if $data.type=='driver'}checked="checked"{/if}> Vairuotojas
			</td>
		</tr>
		<tr>
			<td>Sutarties numeris</td>
			<td><input type="text" class="input" name="u[contract]" value="{$data.contract}"></td>
		</tr>
		<tr>
			<td>Adresas</td>
			<td><input type="text" class="input" name="u[address]" value="{$data.address}"></td>
		</tr>
		<tr>
			<td>Slaptažodis</td>
			<td><input type="password" class="{if !empty($data)}empty{/if} input" name="u[password]" value=""></td>
		</tr>
		<tr>
			<td>Pakartokite slaptažodį</td>
			<td><input type="password" class="{if !empty($data)}empty{/if} input" name="u[confirmpassword]" value=""></td>
		</tr>
		<tr>
			<td>Papildoma informacija</td>
			<td><textarea class="textarea" name="u[extra]">{$data.extra}</textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input type='submit' value='Gerai' /></td>
		</tr>
	</table>
</form>
</div><!-- /.page -->
{include file='footer.tpl'}