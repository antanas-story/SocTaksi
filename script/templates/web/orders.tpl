{include file='header.tpl' title='Užsakymai' metadescrip=''}
<div class="page">
	<h2>{if $current}Einamieji užsakymai{else}Buvę užsakymai{/if}</h2>
	<a href="{$path}" class="button">Naujas užsakymas</a>
	{if $current}
	<a href="{$path}uzsakymai/istorija" class="button">Užsakymų istorija</a>
	{else}
	<a href="{$path}uzsakymai" class="button">Einamieji užsakymai</a>
	{/if}
	<div id="orders">
	{include file='orderlist.tpl'}
	</div>
</div><!-- /.page -->
{include file='footer.tpl'}