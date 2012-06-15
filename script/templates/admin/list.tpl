{if $buttons.filter}
    <form action='admin.php?p={$get.p}' id="aioform" method="GET">
    <div class="tabs" id="widgett">
        <ul>
            <li><a href="#tabs-1">Filtruoti</a></li>
            <li><a href="#tabs-2">Rodyti laukus</a></li>
            <li><a href="#tabs-3">Rikiuoti</a></li>
        </ul>
        <div id="tabs-1">
        <input type='hidden' name='p' value='{$get.p}' />
        {foreach from=$meta key=k item=m name=metaloop}
            {if isset($m.filter)&&$m.filter}
                <div>
                {$m.name}
                {if isset($m.values)}
                    {foreach from=$m.values key=key item=val name=loop}
                    <input id="field{$k}{$key}"{if isset($post.where[$k][$smarty.foreach.loop.index])}checked="checked"{/if} type="checkbox" name="where[{$k}][]" value="{$key}" />
                    <label for="field{$k}{$key}">{$val}</label>
                    {/foreach}
                {elseif isset($m.from)}
                    <select name="where[{$k}]">
                        <option></option>
                    {foreach from=$cache[$m.from] item=c}
                        <option {if isset($post.where[$k]) && $post.where[$k] == $c.id}selected='selected'{/if} value="{$c.id}">{$c[$m.field]}</option>
                    {/foreach}
                    </select>
                    
                {else} 
                    <input type="text" name="where[{$k}]" value="{if isset($post.where[$k])}{$post.where[$k]}{/if}" />
                {/if}
                </div>
            {/if}
        {/foreach}
        <input type='submit' value='Filtruoti' />
        </div>
        <div id="tabs-2">
            {foreach from=$meta key=k item=m name=metaloop}
            {if isset($m.optional)&&$m.optional}
            <div class="field">
                <input id="opt{$k}" {if isset($post.optional[$k])}checked="checked"{/if} type="checkbox" name="optional[{$k}]" value="true" />
                <label for="opt{$k}">{$m.name}</label>
            </div>
            {/if}
            {/foreach} 
            <div><input type='submit' value='Rodyti' /></div>     
        </div>
        <div id="tabs-3">
            <div>
                Pagal
                <select name="order[by]">
                {foreach from=$meta key=k item=m name=metaloop}
                    <option value="{$k}" {if isset($post.order.by) && $post.order.by==$k}selected='selected'{/if}>{$m.name}</option>
                {/foreach}
                </select>
            </div>
            <div>
                Tvarka
                <select name="order[direction]">
                    <option value="desc">mažėjančia (z-a, 9-0)</option>
                    <option value="asc" {if isset($post.order.direction) && $post.order.direction=="asc"}selected='selected'{/if}>didejančia (a-z, 0-9)</option>
                </select>
            </div>
            <div><input type='submit' value='Rikiuoti' /></div>
        </div>
    </div>
    {if $pagination&&$pagination.total>0}
        <p>
        Rodoma {($pagination.page-1)*$pagination.perpage+1}-{if $pagination.page*$pagination.perpage<$pagination.total}{$pagination.page*$pagination.perpage}{else}{$pagination.total}{/if}
        iš {$pagination.total} rezultat{if $pagination.total%10 == 1}o{else}ų{/if}
        </p>
    {/if}
{/if}
{if is_array($items)}    
    <table class='list' cellspacing="0" cellpadding="0">
    <tr>
        {foreach from=$meta key=k item=m}
           {if !isset($m.optional) || !$m.optional || (isset($post.optional[$k]) && $post.optional[$k])}
           <th>
               {if isset($m.orderby)}<a href="{$m.url}" title="Rikiuoti pagal {$m.orderby} {if $m.order eq 'asc'}didėjimo{else}mažėjimo{/if} tvarka">{$m.name}</a>
               {else}
                {$m.name}
               {/if}
           </th>
           {/if}
        {/foreach}
        <th></th>
    </tr>
    {foreach from=$items key=i item=field name=main}
        <tr class='row {if $i % 2 == 0}even{else}odd{/if} {if isset($field.highlight)}highlight{/if}' >
            {foreach from=$meta key=k item=m}
            {if !isset($m.optional) || !$m.optional || (isset($post.optional[$k]) && $post.optional[$k])}
                <td>
                    {if isset($m.folder)}
                        {if $field[$k] eq ''}nėra{else}
                        <a href="{$field[$k]}" target="_blank">peržiūrėti</a>
                        {/if}
                    {else}{$field[$k]}{/if}
                    
                </td>
            {/if}
            {/foreach}
            <td>
                {*if $buttons.review}<a href="{$url}&view={$field.id}">Peržiūrėti</a>{/if*}
                {if $buttons.edit||$superadmin}<a href="{$url}&edit={$field.id}">Keisti</a>{/if}
                {if $buttons.delete||$superadmin}<a href="#" onclick="site.del('{$what}',{$field.id});return false;">Trinti</a>{/if}
            </td>
        </tr>
    {/foreach} 
    </table>
{else}
    <p>Nerasta įrašų</p>
{/if}
{if $buttons.filter}       
    {include file='pagination.tpl'}    
    </form>
{/if}
{if $buttons.new||$superadmin}
<a href="{$url}&new">Naujas</a>
{/if}
