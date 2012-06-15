	<ul class="order-list {if !$current}previous-orders{/if}">
	{foreach $orders as $o}
		<li data-id="{$o.id}" class="{$o.status}">
			<div class="name">{$o.firstname} {$o.lastname} <span>(Sutarties numeris: {$o.contract})</span></div>
			<div class="adress">
				<span>Iš:</span> {$o.addressFrom}<br />
				<span>Į:</span> {$o.addressTo}<br />
				<span>Data:</span> {$o.when|substr:0:10}, {$o.when|date_format:"%A"}<br />
				<span>Laikas:</span> {$o.when|substr:11:-3}<br />
				{if $o.backOn|timestamp > 0}
				<span>Grįžta:</span> {$o.when|substr:11:-3}<br />
				{/if}
				<span>Telefonas:</span> {$o.phone}
			</div>
			{if !empty($o.extra)}
			<div class="more"><span>Papildoma informacija:</span> {$o.extra}</div>
			{/if}
			{if $o.status=="new"}
				<div class="status">Užsakymas laukia patvirtinimo</div>
				<div class="buttons"><a href="#" name="accepted">Patvirtinti</a><a href="#" name="rejected">Atšaukti</a></div>
			{elseif $o.status=="rejected"}
				<div class="status false">Užsakymas atšauktas</div>
				<div class="buttons"><a href="#" name="accepted">Patvirtinti</a></div>
			{elseif $o.status=="accepted"}
				<div class="status true">Užsakymas patvirtintas</div>			
				<div class="buttons"><a href="#" name="rejected">Atšaukti</a></div>
			{/if}
		</li>
	{foreachelse}
		<li>
			Užsakymų nėra.
		</li>
	{/foreach}
	</ul>