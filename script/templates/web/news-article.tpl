{include file='header.tpl' title='Naujienos' metadescrip='Socalinio taksi naujienų puslapyje visada rasite aktualiausias naujienas apie socialinio taksi paslaugą.'}
<div class="page">
	<h2>Naujiena</h2>
		{$url="{$path}naujienos/{$article.slug}"}

			<div class="box">
<a href="{$url}"><img src="{$path}{$smarty.const.IMAGE_UPLOAD_DIR}/t-{$article.logo}" width="211" height="148"></a>
				<div class="content">
					<div class="date">{$article.publishFrom|substr:0:10}</div>
					<h3>{$article.title}</h3>
					{if !empty($article.descriptionfull)}
						{$article.descriptionfull}
					{else}{$article.descriptionshort}{/if}
				</div>
			</div><!-- /.box -->

	
	
	
	
	<h2 style="margin-top:50px;">Kitos naujienos</h2>
	{foreach $news as $n}
		{if $n.id!=$article.id}
			{$url="{$path}naujienos/{$n.slug}"}
			<div class="box">
			<a href="{$url}"><img src="{$path}{$smarty.const.IMAGE_UPLOAD_DIR}/t-{$n.logo}" width="211" height="148"></a>
				<div class="content">
					<div class="date">{$n.publishFrom|substr:0:10}</div>
					<h3><a href="{$url}">{$n.title}</a></h3>
					{$n.descriptionshort}
				</div>
			</div><!-- /.box -->
		{/if}
	{/foreach}			
</div><!-- /.page -->
{include file='footer.tpl'}