<?php
class Content extends Model {
    protected $tableName = "content";
    protected $defaultSort = "name";
    public $failText = "įrašo"; // Nepavyko sukurti/ištrinti/redaguoti ...
    public $sucText = "įrašą"; // Sėkmingai sukurtėme/ištrintėme/redaguotavome ...
    public $loc = "Statinis turinys"; // Šiuo metu naršote: ...
    public $afterEdit = "self";
    
    public function formFields() {
        return array(
            "name"=>array(
                "caption"=>"Puslapio pavadinimas",
                "type"=>"text",
                "name"=>"name",
        		"tip"=>"Naudojamas kaip puslapio titulas"
            ),
            "slug"=>array(
                "caption"=>"Adresas",
                "type"=>"text",
                "name"=>"slug",
            	"tip"=>"Adresas, kuriuo pasiekiamas šis turinys, pvz. adresui http://socialinistaksi.lt/<i>kontaktai</i> reikia vesti <i>kontaktai</i>"
            ),
            "text"=>array(
                "caption"=>"Turinys",
                "type"=>"wysiwyg",
                "name"=>"text",
                "class"=>"extended"
            ),
            "metaDescription"=>array(
                "caption"=>"Meta-aprašymas",
                "type"=>"textarea",
                "name"=>"metaDescription",
            	"tip"=>"Poros sakinių turinio aprašymas matomas googlės paieškoje"
                
            )
            
        );
    }
    public function displayMeta() {
        return array(
            //"id"=>"ID",
            "name"=>array("name"=>"Turinio pavadinimas", "orderby"=>"pavadinimus")
        );
    }    
    public function displayButtons() {
        return array(
            "filter"=>false,
            "edit"=>true,
            "delete"=>true,
            "new"=>true
        );
    }
}
?>