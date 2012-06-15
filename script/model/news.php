<?php
class News extends Model {
    protected $tableName = "news";
    protected $defaultSort = array("publishFrom"=>"desc");
    public $failText = "naujienos"; // Nepavyko sukurti/ištrinti/redaguoti ...
    public $sucText = "naujieną"; // Sėkmingai sukurtėme/ištrintėme/redaguotavome ...
    public $loc = "Naujienos"; // Šiuo metu naršote: ...
    public function formFields() {
        return array(
            "title"=>array(
                "caption"=>"Antraštė",
                "type"=>"text",
                "name"=>"title"
            ),
            "logo"=>array(
                "caption"=>"Pagrindinė nuotrauka",
                "type"=>"picture",
                "name"=>"logo",
            	"tip"=>"Šią naujieną atspindinti nuotrauka",
                "thumbs"=>array(
                    array("caption"=>"Sąraše", "prefix"=>"t-", "width"=>211, "height"=>148)
                )
            ),
            "descriptionshort"=>array(
                "caption"=>"Turinio santrumpa",
                "type"=>"wysiwyg",
                "name"=>"descriptionshort",
                "tip"=>"Rodoma naujienų sąraše"
                
            ),            
            "descriptionfull"=>array(
                "caption"=>"Turinys",
                "type"=>"wysiwyg",
                "name"=>"descriptionfull"
            ),
            "publish"=>array(
                "caption"=>"Publikuoti",
                "type"=>"select",
                "from"=>array(
                    array("id"=>1,"name"=>"taip"),
                    array("id"=>0,"name"=>"ne")
                ),
                "name"=>"publish",
                "tip"=>"Ar rodyti šią naujieną bendrame sąraše"
               
            ),
			"publishFrom"=>array(
                "caption"=>"Publikuoti nuo",
                "type"=>"datetime",
                "name"=>"publishFrom"
            )/*,
            "about"=>array(
                "caption"=>"Rodyti puslapyje Apie",
                "type"=>"select",
                "from"=>array(
                    array("id"=>1,"name"=>"taip"),
                    array("id"=>0,"name"=>"ne")
                ),
                "name"=>"about"
            ),
            *//*,                        
            "comment_lt"=>array(
                "caption"=>"Komentaras LT",
                "type"=>"textarea",
                "name"=>"comment_lt"
            ),
            "comment_en"=>array(
                "caption"=>"Komentaras EN",
                "type"=>"textarea",
                "name"=>"comment_en"
            )*/
        );
    }
    public function displayMeta() {
        return array(
            "title"=>array("name"=>"Antraštė","orderby"=>"antraštės"),
            "publish"=>array("name"=>"Publikuojama","values"=>array(0=>"ne",1=>"taip")),
            "logo"=>array("name"=>"Logotipas","folder"=>IMAGE_UPLOAD_DIR),
            "publishFrom"=>array("name"=>"Publikuojama nuo", "orderby"=>"publikavimo datas"),
            "lastModified"=>array("name"=>"Paskutinį kart redaguota", "orderby"=>"paskutinį kart redaguota")
        );
    }
    public function dataFilter($fields, $creation=false) {
    	$now = date("Y-m-d H:i:s");
    	$fields["slug"] = !empty($fields["title"]) ? $this->slug($fields["title"]) : "";  
        $fields["lastModified"] = $now;
        if($creation) $fields["dateCreated"] = $fields["lastModified"];
        if(empty($fields["publishFrom"])) $fields["publishFrom"] = $now; 
        
        return $fields;
    }
    
    public function grouped() {
        return $this->db->qKey(array("cat","id"), "SELECT * FROM {p}pictures ORDER BY id DESC");
    }
}
?>