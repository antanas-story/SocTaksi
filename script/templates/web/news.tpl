{include file='header.tpl' title='Naujienos' metadescrip='Socalinio taksi naujienų puslapyje visada rasite aktualiausias naujienas apie socialinio taksi paslaugą.'}
<div class="page">
	<h2>Naujienos</h2>
	{foreach $news as $n}
		{$url="{$path}naujienos/{$n.slug}"}
			<div class="box">
			<a href="{$url}"><img src="{$path}{$smarty.const.IMAGE_UPLOAD_DIR}/t-{$n.logo}" width="211" height="148"></a>
				<div class="content">
					<div class="date">{$n.publishFrom|substr:0:10}</div>
					<h3><a href="{$url}">{$n.title}</a></h3>
					{$n.descriptionshort}
				</div>
			</div><!-- /.box -->
	
	{/foreach}		
</div><!-- /.page -->
{include file='footer.tpl'}