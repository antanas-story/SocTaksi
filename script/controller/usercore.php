<?php
class UserCore {
    protected $smarty;
    protected $db;
    protected $absolutepath = ABSOLUTE_PATH;
    protected $absolutelinkpath = ABSOLUTE_PATH;
    protected $superadmin = false;
    protected $admin = false;
    
    public function __construct($db = null) {
        // developer helper
        $this->superadmin = isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] ? true : false;
        $this->admin = isset($_SESSION["admin"]) && $_SESSION["admin"] ? true : false;
        
        $this->smarty = new MySmarty;
        
        if(empty($db)) {
            $this->db = new db();
        } else {
            $this->db = $db;
        }
        $this->smarty->assign('superadmin', $this->superadmin);        
    } 
    public function display() {
        
        // decypher url
        $url = isset($_GET["url"]) ? $_GET["url"] : $this->defaulturl;
        
        $urlpieces = explode("/",$url);
        
        $tpl = $this->determineTpl($urlpieces);
        //absolute path 
        $this->commonNoCache();
        
        //main
        //if(!$this->smarty->is_cached($tpl.".tpl", $url)) {
            $this->common();
            $this->generalTemplate($tpl, $urlpieces);
        //}
        if(isset($_GET['ajax'])) {
            $tpl = $this->ajaxifyTpl($tpl);
        }
        $this->smarty->display($tpl.".tpl", $url);
        
    }   
    
    /* * * TO BE OVERIDDEN * * */
    protected function ajaxifyTpl($tpl) { return $tpl; } 
    protected function commonNoCache() {}
    protected function common() {}
    protected function determineTpl($pieces) {}
    protected function generalTemplate(&$tpl, $urlpieces) {}
    
    protected function pagination($page = 1, $perpage = 5, $total = 0, $url=NULL) {
        $pagination = false;
        if($total > $perpage) {
            $pagination = true;
            $pages = ceil($total/$perpage);
            $page = intval($page);
            if($page<1) $page = 1;
            if($page>$pages) $page = $pages;
            
            for($i=1;$i<=$pages;$i++) {
                $pageArray[$i] = array(
                    "url"=>$url.$i,
                    "caption"=>$i,
                    "selected"=>($page==$i ? true : false)
                );
            }
            
            if($page>1) {
                $this->smarty->assign("previouspage", $pageArray[$page-1]);
            }
            if($page<$pages) {
                $this->smarty->assign("nextpage", $pageArray[$page+1]);
            }

            
            $from = $page-3;
            if($from<1) $from = 1;
            $first = $pageArray[1];
            $last = $pageArray[$pages];
            $pageArray = array_slice($pageArray, $from-1, 7);
            if($page>4) array_unshift($pageArray, $first);
            if($page+3<$pages&&$pages>5) array_push($pageArray, $last);
            /*$pageArray[1] = $first;
            $pageArray[$total] = $last;*/
            //$pagination = 
            $this->smarty->assign("pages", $pageArray);    
        }    
        $this->smarty->assign('pagination', $pagination);        
    }
    protected function count($table, $where=null) {
        $result = $this->db->fetch($table, array("count(*) as count"), $where);
        if(!empty($result))
            return $result[0]["count"];
        else
            return 0;
    }        
}
?>
