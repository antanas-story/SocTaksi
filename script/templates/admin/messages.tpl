{if isset($error)}
    <div class="error ui-corner-all ui-state-error">
        <ul>
        {foreach from=$error item=msg}
            <li>{$msg}</li>
        {/foreach}
        </ul>
    </div>
{/if}

{if isset($highlight)}
    <div class="highlight ui-corner-all ui-state-highlight">
        <ul>
        {foreach from=$highlight item=msg}
            <li>{$msg}</li>
        {/foreach}
        </ul>
    </div>
{/if}