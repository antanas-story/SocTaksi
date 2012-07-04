{include file='header.tpl' title='Atšaukti užsakymai' metadescrip=''}
<div class="page">
	<h2>Atšaukti užsakymai</h2>
	<a href="{$path}" class="button">Naujas užsakymas</a>
	<a href="{$path}uzsakymai/istorija" class="button">Užsakymų istorija</a>
	<a href="{$path}uzsakymai" class="button">Einamieji užsakymai</a>
	<div id="orders">
	{include file='orderlist.tpl'}
	</div>
</div><!-- /.page -->
{include file='footer.tpl'}