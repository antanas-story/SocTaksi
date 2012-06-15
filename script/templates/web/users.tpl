{include file='header.tpl' title='Vartotojai' metadescrip=''}
{function users}
{if !empty($list)}
	<ul class="users-list">
	{foreach $list as $u}
		<li>
			<div class="name">
				{$u.firstname} {$u.lastname}{if !empty($u.contract)} <span>(Sutarties numeris: {$u.contract}){/if}</span>{if !empty($u.phone)}, telefonas: <span>{$u.phone}</span>{/if}
			</div>
			{if !empty($u.address)}
			<div class="adress"><span>Adresas:</span> {$u.address}</div>
			{/if}
			<div class="adress"><span>El. pašto adresas:</span> {$u.email}</div>
			<div class="count">
				{if $u.type!='client'}Priėmė iškvietimą{else}Kvietė mašina{/if}
				<strong>{$u.count}</strong> kart{if ($total%100 >= 11 && $total%100 <= 19) || $total % 10 == 0}ų{elseif $total%10 == 1}ą{else}us{/if}
			</div>
			{if !empty($u.extra)}
			<div class="more"><span>Papildoma informacija:</span> {$u.extra}</div>
			{/if}
			<div class="buttons"><a href="{$path}vartotojai/keisti/{$u.id}">Redaguoti</a>
			{if $u.type!='admin'}<a href="{$path}vartotojai/trinti/{$u.id}">Trinti</a>{/if}
			 </div>
		</li>
	{/foreach}
	</ul>
{/if}	 
{/function}
<div class="page">
	<h2>Vartotojai</h2>
	<a href="{$path}vartotojai/kurti" class="button">Sukurti naują vartotoją</a>
	
	
	<h3 style="clear:left">Klientai</h3>
	{users list=$clients}
	
	<h3>Vairuotojai</h3>
	{users list=$drivers}
	
	<h3>Administratoriai</h3>
	{users list=$admins}
	
	{*foreach $users as $group=>$users}
		{foreach $users as $u}
		<li>
			<div class="name">{if $u.type=='driver'}Vairuotojas{/if}
				{$u.firstname} {$u.lastname} <span>(Sutarties numeris: {$u.contract})</span></div>
			<div class="adress"><span>Adresas:</span> {$u.address}</div>
			<div class="count">
				{if $u.type=='driver'}Priėmė iškvietimą{else}Kvietė mašina{/if}
				<strong>{$u.count}</strong> kartų</div>
			<div class="more"><span>Papildoma informacija:</span> {$u.extra}</div>
			<div class="buttons"><a href="{$path}vartotojai/keisti/{$u.id}">Redaguoti</a>
			{if $o.type!='admin'} | <a href="{$path}vartotojai/trinti/{$u.id}">Trinti</a>{/if}
			 </div>
		</li>
		{/foreach}
	{foreachelse}
		<li>
			Vartotojų nėra
		</li>
	{/foreach*}
	
</div><!-- /.page -->
{include file='footer.tpl'}