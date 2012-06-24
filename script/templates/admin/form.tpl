<form class="input" action="{$url}" method="post" enctype="multipart/form-data">
{if !empty($smarty.get.redirto)}<input type="hidden" name="redirto" value="{$smarty.get.redirto}" />{/if}
<input type="hidden" name="MAX_FILE_SIZE" value="6000000" />
{foreach from=$data key=k item=dat}
    <input type='hidden'
        name="{$k}"
        value="{$dat}" />
{/foreach}
<table>
{function name=name}
fields[{$field.name}]{if !empty($field.clone)}[]{/if}
{/function}
{function name=field}
    {if !isset($first)}{assign var="first" value=true}{/if}
    {if !isset($value)}
        {if isset($field.value)}
            {assign var="value" value=$field.value}
        {else}
            {assign var="value" value=""}
        {/if}
    {/if}
        <div class="field">
            {if $field.type eq 'text'}
                <input
                    name="{name field=$field}"
                    type="text"
                    {if isset($value)}
                    value="{$value|escape}"
                    {/if}
                />
            {elseif $field.type eq 'currency'}
                <input
                    class="currency"
                    name="{name field=$field}"
                    type="text"
                    {if isset($value)}
                    value="{$value}"
                    {/if}
                />                
            {elseif $field.type eq 'date'}
                <input
                    name="{name field=$field}"
                    type="text"
                    {if isset($value)}
                    value="{$value}"
                    {/if}
                    class="datepicker"
                />            
            {elseif $field.type eq 'datetime'}
                <input
                    name="{name field=$field}"
                    type="text"
                    {if isset($value)}
                    value="{$value}"
                    {/if}
                    class="datetimepicker"
                />                  
            {elseif $field.type eq 'textarea'}
                <textarea name="{name field=$field}" {if isset($field.class)}class='{$field.class}'{/if}>{if isset($value)}{$value}{/if}</textarea>
            {elseif $field.type eq 'picture' || $field.type eq 'upload'}
                <div class="uploadfiles" fieldname="{name field=$field}" multiple="false"></div>
                    {if !empty($value)}
                        <div>
                        	{$fn="{$smarty.const.IMAGE_UPLOAD_DIR}/{$value}"}
                            įkeldami perrašysite šį failą <a href="{$fn}" target="_blank">{$value}</a>.
                            {if isset($field.thumbs)}
                            <a href="#" onclick="site.showCropper('pic{$field.name}'); return false;">Kadruoti</a>
                            <div id="pic{$field.name}" class="hidden">
                                <div class="croptabs">
                                    {foreach from=$field.thumbs item=t}
                                    <h3><a href="#">{$t.caption}</a></h3>
                                    <div id="pic{$field.name}{$t@key}" class="cropper">
                                        <div class="cropwrap">
                                            <img src="{$fn}" alt="" class="img" />
                                        </div>
                                        <span class="preview" style="width:{$t.width}px;height:{$t.height}px;">
                                            <img src="{$fn}" class="previewimg" />
                                        </span>
                                        <button class="button" onclick="site.cropPic('pic{$field.name}{$t@key}', '{$value}', '{$t.prefix}');">Išsaugoti</button>
                                    </div>
                                    {/foreach}                                
                                </div>
                            </div>
                            {/if}
                        </div>
                    {/if}
                
            {elseif $field.type eq 'select'}
                {*if $field.from == 'categories'}
                    <select name="{name field=$field}">
                    {foreach from=$categories item=cat name=catloop}
                        <optgroup label="{$cat.name}">
                        {foreach from=$cat.subcat item=sub}
                            <option value="{$sub.id}" {if $sub.id==$currcat}selected="selected"{/if}>{$sub.name}</option>
                        {/foreach}
                        </optgroup>
                    {/foreach}
                    </select>
                {else*}
                    <select name="{name field=$field}">
                        {if isset($field.empty)&&$field.empty}<option value=""></option>{/if}
                        {foreach from=$field.options item=option}
                            <option value="{$option.id}"
                            {if isset($value) && $value == $option.id}selected="selected"{/if}>
                            {$option[$field.remote]}</option>
                        {/foreach}
                    </select>
            {elseif $field.type eq 'wysiwyg'}
                <textarea class="{if !empty($field.class)}{$field.class}{/if} wysiwyg" name="{name field=$field}">{if isset($value)}{$value}{/if}</textarea>
            {elseif $field.type eq 'plane'}
                <b>{$value}</b>
            {elseif $field.type eq 'pictures'}
                    {if is_array($value)}
                    <div class="sortable">
                        {foreach from=$value item=img}
                            <div id="order_{$img.id}" class="image">
                                <div class="handle"><span class="ui-icon ui-icon-arrow-4"></span></div>
                                <a href="imgs/{$img.filename}" target="_blank"><img src="imgs/t-big-{$img.filename}" height="100" /></a><br />
                                {*<img src="imgs/t-{$img.filename}" height="100" /><br />*}
                                <a href="#" title="Trinti šią nuotrauką" onclick="deletePic({$img.id}, this); return false;">Šalinti</a>
                            </div>
                        {/foreach}
                    {/if}
                    <div class="clear"></div>
                    </div>
                <div class="uploadfiles pictures" fieldname="fields[pictures][]" multiple="true"></div>{*<input type="file" class="block" name="fields[pictures][]" />
                <input type="file" class="block" name="pictures[]" id="picUpload" />
                <a href="#" class="hint" onclick="clonePicField(this); return false" title="Paspaudus atsiras dar vienas laukelis nuotraukai">daugiau nuotraukų</a>*}
                <div class="hint">(Max failo dydis 10 MB)</div>
            {/if}
            <a href="#" {if $first}class="hidden"{/if} onclick="$(this).parent().remove(); return false;">x</a>
        </div>
{/function}

{foreach from=$fields item=f name=mainloop}
    <tr>
        <td>{$f.caption}</td>
        <td>
    {if isset($f.value)&&is_array($f.value)&&!empty($f.clone)}
        {foreach from=$f.value item=v}
            {if $v@first}
                {field field=$f value=$v first=true}
            {else}
                {field field=$f value=$v first=false}
            {/if}
        {/foreach}
    {else}
        {field field=$f}
    {/if}
    
    
    {if isset($f.clone)&&$f.clone}
    <a href="#" class="clone">Dar vienas</a>
    {/if}        
    {if isset($f.tip)}<div class="hint">{$f.tip}</div>{/if}    
        </td>
    </tr>    
{/foreach}
<tr><td><input type="submit" value="{$action}"/></td></tr>
</table>
</form>
