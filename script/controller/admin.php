<?php
class Admin extends AdminCore {
    //* * * CUSTOMIZING CORE * * */
    /**
    * Customize the form of specific objects
    * 
    * @param string $page Object's name
    */
    public function customForm($page, $modelObject) {
        $this->formTemplate($modelObject);
        $tpl = "form";
        return $tpl;
    }  
    /**
    * Customize the listing of specific objects
    *   
    * @param string $page Object's name
    */
    public function customView($page, $modelObject) {
        if($page=="pictures") {
            $tpl = "picturesapp";
            $catsObj = new Categories($this->db);
            $this->smarty->assign('categories', $catsObj->fetchKeyId() );
            $picsObj = new Pictures($this->db);                        
            $this->smarty->assign('items', $picsObj->grouped());
            $this->formTemplate($modelObject);
        } else {
            $this->listTemplate($modelObject);
            $tpl = "list";
        }
        return $tpl;
    }
    /**
    * Prepares what you need for the admin home template
    * 
    */
    public function homeTemplate() {
        
        $data = $this->db->fetch("offeredpartners","*",null,null,array(0,1));
        if(!empty($data))
            $this->smarty->assign('offered', true);
    }
    /**
    * Fullfills custom ajax inquiries
    * 
    * @param array $get $_GET array
    * @param array $post $_POST array
    */
    public function customAjax($get, $post) {
        // do custom ajax here
    }    

    //* * * HELPER FUNCTIONS * * */
    
    //* * * ADMIN TOOL SECTION * * */
    /**
    * Method to make custom admin tools
    * @returns string Template filename from admin template folder
    * 
    */
    public function adminTools() {
        $tpl = "home";
        return $tpl;
    }
}
?>