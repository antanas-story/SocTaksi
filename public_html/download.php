<?php
$allowExtensions = array("jpg", "jpeg", "png", "gif");
    
$file = $_GET["f"];

$path = ".".parse_url($file, PHP_URL_PATH);
if(!file_exists($path)) die("Failas nerastas.");

$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
if(!in_array($extension, $allowExtensions)) die("Negalima.");

$filename = pathinfo($path, PATHINFO_BASENAME);

/*
$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
$mime = finfo_file($finfo, $path);
finfo_close($finfo);*/
$size = getimagesize($path);
$mime = $size["mime"];

header("Content-Disposition: attachment; filename=\"$filename\"");   
header("Content-Type: application/force-download");
header("Content-Type: application/download");
header("Content-Type: ".$mime);

header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($path));
flush(); // this doesn't really matter.
$fp = fopen($path, "r");
while (!feof($fp)) {
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp);
?>