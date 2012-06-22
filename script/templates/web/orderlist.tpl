	<ul class="order-list {if !$current}previous-orders{/if}">
	{foreach $orders as $o}
		<li data-id="{$o.id}" class="{$o.status}">
			<div class="adress">
				<div><span>Iš:</span> {$o.addressFrom}</div>
				<div><span>Į:</span> {$o.addressTo}</div>
				<div><span>Data:</span> {$o.when|substr:0:10}, {$o.when|date_format:"%A"}</div>
				<div><span>Laikas:</span> {$o.when|substr:11:-3}</div>
				{if $o.backOn|timestamp > 0}
				<div><span>Grįžta:</span> {$o.when|substr:11:-3}</div>
				{/if}
			</div>
			<div class="more">
				<strong>{$o.firstname} {$o.lastname}</strong>, <span>sutarties numeris:</span> {$o.contract}, <span>telefonas</span> {$o.phone}<br>
			{if !empty($o.extra)}
				<span>Papildoma informacija:</span> {$o.extra}</span>
			{/if}
			</div>
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