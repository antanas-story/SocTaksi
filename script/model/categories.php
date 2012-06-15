<?php
class Categories extends Model {
    protected $tableName = "categories";
    protected $defaultSort = array("order"=>"desc","name_lt"=>"asc");
    public $failText = "kategorijos"; // Nepavyko sukurti/ištrinti/redaguoti ...
    public $sucText = "kategoriją"; // Sėkmingai sukurtėme/ištrintėme/redaguotavome ...
    public $loc = "Nuotraukų kategorijos"; // Šiuo metu naršote: ...
    public function formFields() {
        return array(
            "name_lt"=>array(
                "caption"=>"Kategorijos pavadinimas LT",
                "type"=>"text",
                "name"=>"name_lt"
            ),
            "name_en"=>array(
                "caption"=>"Kategorijos pavadinimas EN",
                "type"=>"text",
                "name"=>"name_en"
            ),
            "order"=>array(
                "caption"=>"Pirmumas",
                "type"=>"text",
                "name"=>"order",
                "tip"=>"Kuo didesnis, tuo pirmiau kategorija bus vaizduojama tinklapyje"
            ),
            "publish"=>array(
                "caption"=>"Publikuoti",
                "type"=>"select",
                "from"=>array(
                    array("id"=>1,"name"=>"taip"),
                    array("id"=>0,"name"=>"ne")
                    
                ),
                "name"=>"publish"
            ),            
        );
    }
    public function displayMeta() {
        return array(
            /*"title"=>array("name"=>"Titulas", "orderby"=>"titulus"),*/
            "order"=>array("name"=>"Pirmumas", "orderby"=>"pirmumą"),
            "name_lt"=>array("name"=>"Pavadinimas LT", "orderby"=>"pavadinimus"),
            "name_en"=>array("name"=>"Pavadinimas EN", "orderby"=>"pavadinimus"),
            "publish"=>array("name"=>"Publikuojama", "values"=>array(1=>"Taip",0=>"Ne") )
        );
    }
    public function dataFilter($fields) {
        if(isset($fields["name_lt"])) $fields["slug_lt"] = $this->slug($fields["name_lt"]);
        if(isset($fields["name_en"])) $fields["slug_en"] = $this->slug($fields["name_en"]);
        
        return $fields;
    }
}
?>