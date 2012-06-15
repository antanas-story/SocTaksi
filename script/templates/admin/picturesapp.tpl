<div id="gal">
{if is_array($items)}
    <div id="galaccord">
        <script type="text/javascript">
        var cropParams = [
        {foreach from=$fields.filename.thumbs item=t}
            { caption:'{$t.caption}', prefix:'{$t.prefix}', width:{$t.width}, height:{$t.height} } {if !$t@last},{/if}
        {/foreach}
        ];
        </script>
    
    {foreach from=$items key=catid item=cat name=main}
        <h3><a href="#">{if isset($categories[$catid])}{$categories[$catid].name_lt}{else}Be kategorijos{/if}</a></h3>
        <div class="pictures">
            {foreach from=$cat item=pic}
            <div class="pic">
                {*<span class="tooltip" title="Kurioje kategorijoje yra nuotrauka">Kategorija {if isset($categories[$pic.cat])}{$categories[$pic.cat].name_lt}{else}none{/if}</span><br />*}
                {*if $pic.about==1}<span class="icon about" title="Ši nuotrauka rodoma apie skiltyje">&nbsp;</span>{/if}
                {if $pic.titular==1}<span class="icon titular" title="Ši nuotrauka rodoma tituliniame puslapyje">&nbsp;</span>{/if*}
                <button class="cropbutton" onclick="site.showCropper(cropParams, '{$pic.filename}');">Kadruoti</button>
                {*<button class="editbutton" onclick="alert('keisti');">Keisti</button>*}
                <button class="deletebutton" onclick="site.del('pictures', {$pic.id}, this)">Trinti</button>
                <img src="imgs/t-small-{$pic.filename}" alt="" />
            </div>
            {/foreach}
        </div>
    {/foreach}
    </div>
{else}
    <p>Nerasta įrašų</p>
{/if}

    <div class='inlineform'>
        <div class="toggleNext"><span class="header">Įkelti naują nuotrauką (-as)</span> <a href="#" onclick="$(this).parent().nextAll('.form').slideToggle(300);return false;">rodyti/slėpti</a></div>
        <div class="form hidden">
            {include file='form.tpl'}
        </div>
    </div>

</div>