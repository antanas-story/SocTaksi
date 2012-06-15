<?xml version="1.0" encoding="utf-8" ?>
{function rssDate}
{$ts=strtotime($date)}
{$dateformat|date:$ts}
{/function}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Naujienos - Socialinis Taksi</title>
    <link>{$path}naujienos</link>
    <description>Socalinio taksi naujienų puslapyje visada rasite aktualiausias naujienas apie socialinio taksi paslaugą.</description>
    <lastBuildDate>{rssDate date=$news[0].lastModified}</lastBuildDate>
    <language>lt-LT</language>
    <atom:link href="{$path}naujienos/rss" rel="self" type="application/rss+xml" />
    {foreach $news as $n}
    <item>
       <title>{$n.title}</title>
       <link>{$path}naujienos/{$n.slug}</link>
       <guid>{$path}naujienos/{$n.slug}</guid>
       <pubDate>{rssDate date=$n.publishFrom|substr:0:10}</pubDate>
       <description>{$n.descriptionshort|htmlspecialchars}</description>{*
       <image>{$path}{$smarty.const.IMAGE_UPLOAD_DIR}/t-{$n.logo}</image>*}
    </item>
    {/foreach}
  </channel>
</rss>
{*	Kokie kintamieji gali būti naudojami šiame template
	{$path} - http://socialinistaksi.lt/
	{$n.id} - naujienos id
    {$n.slug} - naujienos unikalus URL identifikatorius, pilnas adresas - {$path}naujienos/{$n.slug}
    {$n.title} - naujienos antraštė—
    {$n.descriptionshort} - trumpas aprašymas (su html tag'ais)
    {$n.descriptionfull} - pilnas aprašymas
    {$n.publish} - ar publikuojama ši naujiena. šiuo atveju visada 1
    {$n.publishFrom} - nuo kada publikuojama ši naujiena 
    {$n.logo} - logotipo failo pavadinimas, thumbnail'as su "t-" priekyje. Pilnas adresas {$path}{$smarty.const.IMAGE_UPLOAD_DIR}/t-{$n.logo}
    {$n.dateCreated} - kada sukurta ši naujiena
    {$n.lastModified} - kada paskutinį kartą redaguota ši naujiena
*}