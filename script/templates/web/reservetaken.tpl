{include file='header.tpl' title='Rezervacija' metadescrip=''}
<div class="page" id="rezervation">
<form action="{$path}rezervuoti" method="post" id="theform">
	
	<div class="wrong"><strong>Dėja, jūsų nurodytu laikų laivų mašinų neturėsime. Prašome pasirinkti kitą laiką</div>
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
	<input type='submit' value='Rezervuoti' />
	</div>
	
</form>

	<div id="busyness" class="box">
		<div class="heading">Socialinio taksi užimtumas</div>
		
		{foreach $orders as $day=>$list}
		<div class="day">
			<span>{$day}, {$day|date_format:"%A"}</span>
			<div class="holder">
				<div class="empty"></div>
			</div>
			{foreach $list as $order}
				<input type='hidden' class='ordered' value='{$order.when}' data-minutes="{$order.minutes}" />
			{/foreach}
		</div>
		{if $list@iteration >= 3}{break}{/if}
		{/foreach}
	</div>


</div><!-- /.page -->

{include file='footer.tpl'}