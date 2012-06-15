{include file='header.tpl' title='Rezervacija' metadescrip=''}
<div class="page" id="rezervation">
<form action="{$path}rezervuoti/patvirtinti" method="post" id="theform">
	<div class="correct"><strong>Jūsų nurodytu laiku mašina bus laisva!</strong><br>Užpildykite likusias užakymo laukelius ir laukite patvirtinimo iš vairuotojo</div>
	<div class="box">
		<div class="heading">Keleivio adresas</div>
		<div class="content">
			Prašau pasiimti mane iš
			<span class="input-holder">
				<label>Vieta</label>
				<input
					type="text"
					title="Gatvė bei namo numeris"
					class="input place"
					id="addressField"
					name="address"
					value="{$data.address}" />
			</span>
			Šituo laiku
			<span class="input-holder">
				<label>Data</label>
				<input type="text" value="{$data.date}" class="input date" id="dateField" name="date" />
				<a href="#" class="cal calendarIcon"></a>
			</span>
			<span class="input-holder">
				<label>Laikas</label>
				<input type="text" title="VV:MM" value="{$data.time}" class="input time" id="timeField" name="time" />
			</span>
		</div>
	</div>

	<div class="box">
		<div class="heading">Kelionės tikslas</div>
		<div class="content">
			Važuosim į
			<span class="input-holder">
				<label>Vieta</label>
				<input
					type="text"
					title="Gatvė bei namo numeris"
					class="input place"
					id="addressToField"
					name="addressTo" />
			</span>
			<br>
			<input type="checkbox" />Norėčiau, kad mane nuvežtų atgal į <strong id="addressClone">{$data.address}</strong> šituo laiku
			<span class="input-holder">
				<label>Laikas</label>
				<input type="text" title="VV:MM" value="VV:MM" class="input time empty" id="backOnField" name="backOn" />
			</span>
		</div>
	</div>

	<div class="box">
		<div class="heading">Papildoma informacija</div>
		<div class="content">
			Jeigu Jūs norite palikty nurodymus vairotojui arba turite kažkokios papildomos informacijos, užpildykite laukelį
			<span class="input-holder"><textarea rows="5" cols="5" name="extra" class="more-info input"></textarea></span>
		</div>
	</div>
	<input type='submit' value='Rezervuoti' />

</div><!-- /.page -->

{include file='footer.tpl'}