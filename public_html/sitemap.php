<?php
include "default.php";

class Sitemap {
    public $db;
    protected $urls;
    public $urlpath = "http://dailycard.lt/";

    public function __construct(&$db) {
        $this->db = $db;
    }
    public function display() {
        foreach($this->urls as $url=>$data) {
            echo "";
            echo"
   <url>
        <loc>{$this->urlpath}{$url}</loc>";
      
            foreach($data as $key=>$val) {
                echo "
        <$key>$val</$key>";
            }
            echo "
   </url>";
        }
    }
    public function add($url, $lastmod="", $p="", $changefreq="") {
        $array = array();
        if(!empty($p)) $array["priority"] = $p;
        if(!empty($lastmod)) $array["lastmod"] = date("Y-m-d", strtotime($lastmod));
        if(!empty($changefreq)) $array["changefreq"] = $changefreq;
        $this->urls[$url] = $array;
    }
}

$today = date("Y-m-d");
$db = new db();
$s = new Sitemap($db);
$s->add("", $today, "1.0", "weekly");
$s->add("apie-kortele", "2010-11-10", "0.9");
$s->add("apie-kortele/duk", "2010-11-10", "0.9");
$s->add("kontaktai", "2010-11-10", "0.8");


$newscatobj = new Newscategories($db);
$newscats = $newscatobj->fetchKeyId();
$obj = new News($db);
$data = $obj->fetchAll("lastModified", "desc", null, array("publish"=>1));
$lastupdate = $data[0]["lastModified"];
if(is_array($newscats)) foreach($newscats as $i) {
    $s->add("naujienos/{$i["slug"]}", $lastupdate, "0.7");
}
$s->add("naujienos", $lastupdate, "0.9", "weekly");
if(is_array($data)) foreach($data as $i) {
    $s->add("naujienos/{$newscats[$i["category"]]["slug"]}/{$i["slug"]}", $i["lastModified"], "0.6");
}

$obj = new Categories($db);
$data = $obj->fetchAll();
if(is_array($data)) foreach($data as $i) {
    $s->add("nuolaidos/{$i["slug"]}", $today, "0.5", "weekly");
    if(isset($i["subcat"])) foreach($i["subcat"] as $sub) {
        $s->add("nuolaidos/{$sub["slug"]}", $today, "0.5", "weekly");
    }
}

$obj = new Weeklycities($db);
//$data = $obj->fetchAll(null, null, null, array("publish"=>1, "end"=>array(">="=>date("Y-m-d H:i:s"))) );
$data = $obj->fetchAll();
$s->add("dienos-pasiulymai", $data[0]["lastModified"], "0.9", "weekly");
$s->add("dienos-pasiulymai/kaip-tai-veikia", "2010-11-10", "0.9", "monthly");
if(is_array($data)) foreach($data as $i) {
    $s->add("dienos-pasiulymai/{$i["slug"]}", $today, "0.8", "daily");
}

$obj = new Fighters($db);
$data = $obj->fetchAll();
if(is_array($data)) foreach($data as $i) {
    $s->add("kovotojai/{$i["slug"]}", "0.1");
}

/*kategorija
naujienos
renginiai
pasiulymai
labdara
daily-blog*/
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><?php $s->display(); ?></urlset>