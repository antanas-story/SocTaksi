<?php
$tables=array(
    "content"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "slug"=>"VARCHAR(255) NOT NULL",
        "name"=>"VARCHAR(255) NOT NULL",
        "text"=>"TEXT NULL",
    ),
    "categories"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "order"=>"INT NOT NULL DEFAULT 0",
        "name_lt"=>"VARCHAR(255) NOT NULL",
        "slug_lt"=>"VARCHAR(255) NOT NULL",
        "name_en"=>"VARCHAR(255) NOT NULL",
        "slug_en"=>"VARCHAR(255) NOT NULL"        
    ),
    "pictures"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "cat"=>"INT NOT NULL DEFAULT 0",
        "titular"=>"BOOL DEFAULT 0",
        "about"=>"BOOL DEFAULT 0",
        "filename"=>"VARCHAR(255) NOT NULL",
        "comment_lt"=>"TEXT NULL",
        "comment_en"=>"TEXT NULL"
    ),
    "users"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "username"=>"VARCHAR(255) NOT NULL",
        "password"=>"VARCHAR(255) NOT NULL",
        "type"=>"INT NOT NULL DEFAULT 0"
    ),
    "playlist"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "order"=>"INT NOT NULL DEFAULT 0",
        "name"=>"VARCHAR(255) NOT NULL",
        "filename"=>"VARCHAR(255) NOT NULL"
    ),
	"news"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "slug"=>"VARCHAR(255) NOT NULL",
        "title"=>"VARCHAR(255) NOT NULL",
        "descriptionshort"=>"TEXT NOT NULL",
        "descriptionfull"=>"TEXT NOT NULL",
        "publish"=>"BOOL NOT NULL",
        "publishFrom"=>"DATETIME NULL",
        "logo"=>"VARCHAR(255) NULL",
    	"dateCreated"=>"DATETIME NOT NULL",
        "lastModified"=>"DATETIME NOT NULL"
    	/*,
        "youtube"=>"VARCHAR(255) NULL",
        */
    ),    
    /*,
    "subcategories"=>array(
        "id"=>"INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
        "cat"=>"INT NOT NULL",
        "name"=>"VARCHAR(255) NOT NULL"    
    )*/
);

foreach($tables as $tname=>$table) {
    $f = array();
    foreach($table as $fname=>$field) {
        $f[] = "`$fname` $field";
    }
    $query[$prefix.$tname] = "CREATE TABLE `{$prefix}{$tname}` (".implode(', ',$f).")";
}
  
?>