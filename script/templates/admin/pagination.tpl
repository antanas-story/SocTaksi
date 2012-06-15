{if isset($pagination)&&$pagination.total>0}
    <p class="pagination">
    <input type="hidden" id="page" name="page" />
    {if isset($pagination.previouspage)}
        <a href="{$pagination.previouspage}"><</a>
    {/if}
    {if isset($pagination.pages)}
        {foreach from=$pagination.pages item=page name=part key=i}
            {if $page.selected}
                <span class="page selected">{$page.caption}</span>
            {else}
                <a href="{$page.url}" class="page">{$page.caption}</a>
            {/if}
        {/foreach}
    {/if}
    {if isset($pagination.nextpage)}
        <a href="{$pagination.nextpage}">></a>
    {/if}
    </p>
{/if}