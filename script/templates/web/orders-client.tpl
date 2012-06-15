{include file='header.tpl' title='Užsakymai' metadescrip=''}
<div class="page">
	<h2>Užsakymų istorija</h2>
	<a href="{$path}" class="button">Naujas užsakymas</a>
	<div id="orders">
		<ul class="order-list order-list-client">
		{foreach $orders as $o}
			<li data-id="{$o.id}" class="{$o.status}">
				<div class="name">
					
					{if $o.status=="accepted"}
						PATVIRTINTAS
					{elseif $o.status=="new"}
						LAUKIA VAIRUOTOJO PATVIRTINIMO
					{elseif $o.status=="rejected"}
						ATŠAUKTAS
					{/if}
					<span>
					{if $o.when|timestamp < $now}(SENAS)
					{else}(EINAMASIS)
					{/if}
					</span>
				</div>
				<div class="adress">
					<span>Iš:</span> {$o.addressFrom}<br />
					<span>Į:</span> {$o.addressTo}<br />
					<span>Data:</span> {$o.when|substr:0:10}, {$o.when|date_format:"%A"}<br />
					<span>Laikas:</span> {$o.when|substr:11:-3}<br />
					{if $o.backOn|timestamp > 0}
					<span>Grįžti:</span> {$o.when|substr:11:-3}<br />
					{/if}
					{if !empty($o.firstname)}
					<span>Vairuotojas:</span> {$o.firstname} {$o.lastname} {if !empty($o.phone)}({$o.phone}){/if}
					{/if}
				</div>
				<div class="more"><span>Papildoma informacija:</span> {$o.extra}</div>
				{if $current}
				{if $o.status=="new"}
					<div class="status">Užsakymas laukia patvirtinimo</div>
					<div class="buttons"><a href="#" name="accepted">Patvirtinti</a> | <a href="#" name="rejected">Atšaukti</a></div>
				{elseif $o.status=="rejected"}
					<div class="status false">Užsakymas atšauktas</div>
					<div class="buttons"><a href="#" name="accepted">Patvirtinti</a></div>
				{elseif $o.status=="accepted"}
					<div class="status true">Užsakymas patvirtintas</div>			
					<div class="buttons"><a href="#" name="rejected">Atšaukti</a></div>
				{/if}
				{/if}
			</li>
		{foreachelse}
			<li>
				Jūs dar neturėjote užsakymų.
			</li>
		{/foreach}
		</ul>
	</div>
</div><!-- /.page -->
{include file='footer.tpl'}