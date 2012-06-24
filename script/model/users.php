<?php
class Admins extends Model {
    protected $tableName = "admins";
    protected $defaultSort = "username";
    public $failText = "vartotojo";
    public $sucText = "vartotoją";
    public $loc = "Vartotojai";
    public function formFields() {
        return array(
            "username"=>array(
                "caption"=>"Vartotojo vardas",
                "type"=>"text",
                "name"=>"username"
            ),
            "password"=>array(
                "caption"=>"Slaptažodis",
                "type"=>"text",
                "name"=>"password"
            ),
            "type"=>array(
                "caption"=>"Tipas",
                "type"=>"select",
                "from"=>array(
                    array("id"=>0,"name"=>"Simple"),
                    array("id"=>1,"name"=>"Editor"),
                    array("id"=>2,"name"=>"Admin")
                ),
                "name"=>"type"
            )
        );
    }
    public function displayMeta() {
        return array(
            //"id"=>"ID",
            "username"=>array("name"=>"Vartotojo vardas", "orderby"=>"vartotojų vardus"),
            "password"=>array("name"=>"Slaptažodis", "orderby"=>"slaptažodžius"),
            "type"=>array("name"=>"Tipas", "orderby"=>"tipus")
        );
    }
}
?>