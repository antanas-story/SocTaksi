{include file='header.tpl' title='Statistika' metadescrip=''}
<div class="page">
	<h2>Statistika</h2>
	
	<div id="stats">
		<div>Vartotojų: <strong>{$totalUsers}</strong></div>
		<div>Vienas vartotojas vidutiniškai padaro <strong>{$ordersPerMonthPerUser|round:2}</strong> užsakymų į mėnesį</div>
		<div>
			Iš viso užsakymų: <strong>{$orders|array_sum}</strong>.
			Iš jų patvirtinta: <strong>{$orders.accepted}</strong>,
			atšaukta: <strong>{$orders.rejected}</strong>,
			neapdorota: <strong>{$orders.new}</strong>
		</div>
		<div title='Dar neįvykę, bet užsakyti. Statusas - neapdoroti ir patvirtinti'>
			Einamųjų užsakymų: <strong>{$ongoingOrders}</strong>
		</div>
		{$ordersInMinutes=30*$orders.accepted}
		{$ordersInHours=($ordersInMinutes/60)|floor}
		<div>Bendras priimtų užsakymų laikas: <strong> {$ordersInHours} val. {$ordersInMinutes-$ordersInHours*60} min.</strong></div>
		<div title='Skaičiuojama nuo 2012-06-01'>
			Užsakymų/diena: <strong>{$ordersPerDay|round:2}</strong>
		</div>
	</div>
</div><!-- /.page -->
{include file='footer.tpl'}