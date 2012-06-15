{include file='header.tpl' title='' metadescrip=$titular.metaDescription}

<div class="about">
	{$titular.text}
</div><!-- /.about -->
<div class="rezervation">
	<h2>Socialinio taksi rezervacija</h2>
	<form action="{$path}rezervuoti" method="post" id="theform" class="{if empty($user)}unregistered{/if}">
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
				<input type="text" value="{"Y-m-d"|date}" class="input date" id="dateField" name="date" />
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

{include file='footer.tpl'}