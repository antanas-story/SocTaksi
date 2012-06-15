<?php

class AdminCore {
    protected $smarty;
    public $db;
    protected $loc;
    protected $superadmin;
    protected $availActions = array("add", "set", "del");
    protected $fieldNamesToIMGSdir = array("logo", "picture");
    //protected $availObjects = array("banners", "cities", "categories", "users", "partners", "content", "news", "offers", "events", "router", "blog", "charity", "offered", "travel", "fighters");
    protected $allowedExtensions = array("jpg", "jpeg", "gif", "png", "swf");    
    
    public function __construct() {
        $this->smarty = new MySmarty;
        $this->smarty->template_dir = SMARTY_ADMIN_TEMPLATE_DIR;
        $this->db = new db();
        if(!isset($_SESSION['uid'])||!isset($_SESSION['admin'])) { 
            if(isset($_GET["ajax"])) {
                $response["redir"] = "login.php?expired";
                echo json_encode($response);
                die;
            } else {
                header("Location: login.php"); die;
            }
        }
        $this->smarty->assign('session', $_SESSION);
        $this->superadmin = isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] ? true : false;
        $this->smarty->assign('superadmin', $this->superadmin);
    }
    
    //* * * CUSTOMIZE METHODS - TO BE OVERRIDEN * * *//
    public function customForm($page, $modelObject) { $this->formTemplate($modelObject); return "form";  } 
    public function customView($page, $modelObject) { $this->listTemplate($modelObject); return "list"; }
    public function homeTemplate() {}
    public function customAjax($get, $post) { }
    
    //* * * DATA HANDLERS * * */
    public function handlePost($redir = TRUE) {
        $this->handleFiles();
        if(isset($_POST['action'])&&in_array($_POST['action'], $this->availActions)) {
            $action = $_POST['action'];
            if(isset($_POST['what'])) {
                $what = $_POST['what'];
                $obj = new $what($this->db);
                if($action=="add") {
                    $params = array($_POST['fields']);
                } elseif($action=="set") {
                    $params = array($_POST['id'],$_POST['fields']);
                } elseif($action=="del") {
                    $params = array($_POST['id']);
                }
                if(isset($_POST['fields'])) $this->handleThumbs( $_POST['fields'], $obj->formFields() );
                $answer = call_user_method_array($action,$obj,$params);
                if($answer) {
                    $this->message( constant('SUC_MSG_'.strtoupper($action))." ".$obj->sucText );
                } else {
                    $this->error( constant('FAIL_MSG_'.strtoupper($action))." ".$obj->failText.". ".$this->db->lasterror );
                }
                if($obj->afterEdit=="self"&&($action=="add"||$action=="set")) {
                    if($action=="add") {
                        $url = "admin.php?p=".$_GET['p']."&edit=".$answer;
                    } elseif($action=="set") {
                        $url = "admin.php?p=".$_GET['p']."&edit=".$_POST['id'];
                    }
                    $response["redir"] = $url;
                    echo json_encode($response);
                    die;
                }
                if($redir) {
                    $url = "admin.php?p=".$_GET['p'];
                    header("Location: $url");
                }
            }
        }
    }
    protected function handleThumbs($postFields, $formFields) {
        if(is_array($formFields)) {
            foreach($formFields as $key=>$field) {
                if( isset($field["thumbs"]) &&
                    (
                        isset($postFields[$key]) ||
                        ( $field["type"]=="pictures" && isset($postFields["pictures"]) )
                    ) ) {
                    foreach($field["thumbs"] as $thumb) {
                        if( $field["type"]=="pictures" && isset($postFields["pictures"]) ) {
                            foreach($postFields["pictures"] as $fn) {
                                $this->mkThumb($thumb, $fn);
                            }
                        } else {
                            $this->mkThumb($thumb, $postFields[$key]);
                        }
                    }
                }
            }
        }
    }
    protected function mkThumb($thumb, $fn) {
        $path = "./".IMAGE_UPLOAD_DIR."/".$fn;
        if(file_exists($path)&&!is_dir($path)) {
            $img = new Image($path);
            $fname = pathinfo($path, PATHINFO_FILENAME);
            $img->makeThumb($thumb["width"], $thumb["height"], $thumb["prefix"].$fname, NULL, "crop");
            debugDump("making thumb {$thumb["width"]}x{$thumb["height"]}, from $path, to {$thumb["prefix"]}$fname");
        }        
    }
    public function handleFiles() {
        if(!empty($_FILES)) {
            if(isset($_FILES["pictures"])) {
                foreach($_FILES["pictures"]["name"] as $key => $fname) {
                    if($_FILES["pictures"]["error"][$key] == 0) {
                        $this->handleFile($fname, $_FILES["pictures"]["tmp_name"][$key], "imgs", "pictures");
                    } else {
                        if($_FILES["pictures"]["error"][$key]!=4)
                            $this->error(FILE_UPLOAD_ERR.constant("UPLOAD_ERR_".$_FILES["pictures"]["error"][$key]));
                    }
                }
            }
            elseif(isset($_FILES["fields"]))
                foreach($_FILES["fields"]["name"] as $key => $fname) {
                    if($_FILES["fields"]["error"][$key] == 0) {
                        $dir = "imgs";
                        $this->handleFile($fname, $_FILES["fields"]["tmp_name"][$key], $dir, $key);
                    } else {
                        if($_FILES["fields"]["error"][$key]!=4)
                            $this->error(FILE_UPLOAD_ERR.constant("UPLOAD_ERR_".$_FILES["fields"]["error"][$key]));
                    }
                }
            else { // ajax uploads
                foreach($_FILES["pictures"]["name"] as $key => $fname) {
                    if($_FILES["pictures"]["error"][$key] == 0) {
                        $this->handleFile($fname, $_FILES["pictures"]["tmp_name"][$key], "imgs", "pictures");
                    } else {
                        if($_FILES["pictures"]["error"][$key]!=4)
                            $this->error(FILE_UPLOAD_ERR.constant("UPLOAD_ERR_".$_FILES["pictures"]["error"][$key]));
                    }
                }
            }
        }
    }
    public function handleFile($fname, $tmpname, $dir, $var=NULL) {
        $extension = pathinfo($fname, PATHINFO_EXTENSION);
        if(in_array(strtolower($extension), $this->allowedExtensions)) {
            $i = 0;
            do {
                $i++;
                $tmp = $i > 1 ? "_".$i : "";
                $newfname = pathinfo($fname, PATHINFO_FILENAME).$tmp.".".$extension;
                $path = $dir."/".$newfname;
            } while (file_exists($path));
            
            if (!@move_uploaded_file($tmpname, $path)) {
                $this->error(FILE_UPLOAD_ERR);
                return false;
            } else {
                if($_GET["ajax"]) {
                    $response["filename"] = $newfname;
                    echo json_encode($response);
                } else {
                    if($var!="pictures") {
                        $_POST["fields"][$var] = $newfname;
                    } else {
                        $_POST["fields"][$var][] = $newfname;
                    }
                }
                return true;
                //success
            }
        } else {
            $this->error(FILE_UPLOAD_ERR.UPLOAD_ERR_BAD_EXT);
            return false;
        }        
    }
    
    //* * * ERROR/MESSAGE HANDLERS * * */
    public function error($str) {
        $_SESSION['messages']['error'][] = $str;
    }
    public function message($str) {
        $_SESSION['messages']['notify'][] = $str;
    }
    public function messages() {
        if(isset($_SESSION['messages'])) {
            echo json_encode($_SESSION['messages']);
                
            unset($_SESSION['messages']);
            
            return;
            if(isset($_SESSION['messages']['error']))
                $this->smarty->assign('error',$_SESSION['messages']['error']);
        
            if(isset($_SESSION['messages']['notify']))
                $this->smarty->assign('highlight',$_SESSION['messages']['highlight']);
            
            $this->smarty->display("messages.tpl");            
        }
    }
    
    //* * * DISPLAY/TEMPLATE FUNCTION * * */ 
    public function display($ajax=false) {
        if($_SESSION['superadmin']) $this->smarty->assign('superadmin', 'yes');
        $this->loc = array();
        $this->loc[] = array("name"=>HOMEPAGE_LOC,"url"=>"admin.php");
        
        if(isset($_GET['p'])&&$_GET['p']!="tools") {
            $p = $_GET['p'];
            $this->smarty->assign('what', $p);
            $url = "admin.php?p=".$p;
            $obj = new $p($this->db);
            $this->loc[] = array("name"=>$obj->loc,"url"=>$url);
            $this->smarty->assign('url', $url);
            if(isset($_GET['edit'])||isset($_GET['new'])) {
                $tpl = $this->customForm($p, $obj);
            } else {
                $tpl = $this->customView($p, $obj);
            }
        } elseif(isset($_GET['p'])&&$_GET['p']=="tools") {
            $tpl = $this->adminTools();
            $this->loc[] = array("name"=>"Įrankiai","url"=>"admin.php");
            
        } else {
            $this->homeTemplate();
            $tpl = "home";
        }
        if(!$ajax) {
            $this->smarty->assign("location", $this->loc);
            $this->smarty->display('header.tpl');            
            $this->smarty->display($tpl.".tpl");
            $this->smarty->display('footer.tpl');
        } else {
            $response = array();
            ob_start();
            $this->smarty->display($tpl.".tpl");
            $html = ob_get_contents();
            ob_end_clean();
            if(isset($_SESSION["debug"])) {
                $html .= $_SESSION["debug"];
                unset($_SESSION["debug"]);
            }
            $response["content"] = $html;
            $response["location"] = $this->loc;
            echo json_encode($response);
        }
    }
    public function formTemplate($obj) {
        $p = $_GET['p'];
        $url = "admin.php?p=".$p;
        
        $data = array();
        $fields = $obj->formFields();
        $data["what"] = $p;
        if(is_array($fields))
            foreach($fields as $key=>$field) {
                if($field["type"]=="select") {
                    if(!isset($field["remote"])) $fields[$key]["remote"] = "name";
                    if(is_array($field["from"])) {
                        $fields[$key]["options"] = $field["from"];
                    /*} elseif($field["from"]=="categories") {
                        $cats = new Categories($this->db);
                        $this->smarty->assign("categories", $cats->fetchAll());*/
                    } else {
                        $tmp = new $field["from"]($this->db);
                        $tmp2 = $tmp->fetchAll();
                        $fields[$key]["options"] = $tmp2;
                    }
                }
            }
        if(isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $data["id"] = $id;
            $f = $obj->fetchById($id);
            foreach($fields as $key=>$field) {
                if(isset($f[$key])) {
                    $fields[$key]["value"]=$f[$key];
                }
            }
            $this->loc[] = array("name"=>EDIT_LOC,"url"=>$url."&edit=".$id);
            $data["action"] = "set";
            $action = ACTION_EDIT;
        } else {
            $this->loc[] = array("name"=>NEW_LOC,"url"=>$url."&new");
            $data["action"] = "add";
            $action = ACTION_NEW;
        }
        if(!empty($data)) {
            $this->smarty->assign('data', $data);
        }
        $this->smarty->assign('fields', $fields);
        $this->smarty->assign('action', $action);
    }
    public function listTemplate($modelobject) {
        $url = "admin.php?p=".$_GET{'p'};
        
        $meta = $modelobject->displayMeta();
        if(method_exists($modelobject, "displayButtons")) {
            $buttons = $modelobject->displayButtons();    
        } else {
            $buttons = array("filter"=>false, "edit"=>true, "delete"=>true, "new"=>true);            
        }
        $this->smarty->assign("buttons", $buttons);
        
        $w = isset($_POST['where']) ? $_POST['where'] : null;
        if(is_array($w)) {
            foreach($w as $key=>$val) {
                if($val=="") unset($w[$key]);
                //else $w[$key] = array("LIKE"=>"%{$val}%");
            }
        }
        $limit = null;
        if($buttons["filter"]) {
              $total = $modelobject->count($w);
              debugDump($this->db->lastquery, "last db q after counting");
              debugDump($this->db->lasterror, "last db error after counting");
              $page = !empty($_POST["page"]) ? $_POST["page"] : 1;
              $perpage = !empty($_POST["perpage"]) ? $_POST["perpage"] : 25;
              $this->pagination($page,$perpage,$total);
              $limit = array(($page-1)*$perpage, $perpage);
        }
        debugDump($_POST, 'POST');
        
        $orderby = isset($_POST["order"]["by"]) ? $_POST["order"]["by"] : (isset($_GET['orderby']) ? $_GET['orderby']: false);
        $orderdirection = isset($_POST["order"]["direction"]) ? $_POST["order"]["direction"] : (isset($_GET['order']) ? $_GET['order'] : "asc");
        $this->smarty->assign('get', $_GET);
        $this->smarty->assign('post', $_POST);
        if($orderby) {
            $fetched = $modelobject->fetchAll($orderby, $orderdirection, $limit, $w);
        } else {
            $fetched = $modelobject->fetchAll(null, null, $limit, $w);
        }
        
        $cache = array();
        
        // išvedinėjimo subtilybės
        foreach($meta as $key=>$elem) {
            if(isset($elem["from"])) {       
                $tmp = new $elem["from"]($this->db);
                if(method_exists($tmp, "fetchKeyId"))
                    $cache[$elem["from"]] = $tmp->fetchKeyId();
                if(!empty($fetched)) {
                    foreach($fetched as $k=>$val) {
                        $q = $tmp->fetchById($fetched[$k][$key]);
                        $field = !empty($elem["field"]) ? $elem["field"] : "name";
                        $fetched[$k][$key] = $q[$field];
                    }
                }
            }
            if(isset($elem["folder"])) {
                $path = $elem["folder"]."/";
                if(!empty($fetched))
                    foreach($fetched as $k=>$val) {
                    if(!empty($val[$key]))
                        $fetched[$k][$key] = $path.$val[$key];
                    }                
            }
            if(isset($elem["orderby"])) {
                $order = "asc";
                if(isset($_GET['orderby']) && $_GET['orderby']==$key) {
                    $meta[$key]["current"] = $_GET['order'];
                    if(isset($_GET['order']) && $_GET['order']=="asc") $order = "desc";
                }
                $meta[$key]["url"] = $url."&orderby=".$key."&order=".$order;
                $meta[$key]["order"] = $order;
            }
            if(isset($elem["values"])) {
                if(!empty($fetched))                
                     foreach($fetched as $k=>$val) {
                        $fetched[$k][$key] = $elem["values"][$fetched[$k][$key]];
                    }
            }
            if(isset($elem["limit"])) {
                if(!empty($fetched))                
                    foreach($fetched as $k=>$val) {
                        if(!empty($fetched[$k][$key])) {
                            $fetched[$k][$key] = substr($fetched[$k][$key], 0, $elem["limit"])."...";
                        }
                    }                    
            }
        }
        
        $this->smarty->assign('cache',$cache);
        $this->smarty->assign('meta',$meta);
        $this->smarty->assign('items',$fetched);
                
    }
    protected function pagination($page = 1, $perpage = 10, $total = 0, $url=NULL) {
        $pagination = array(
            "total"=>$total,
            "perpage"=>$perpage,
            "page"=>$page
        );
        if($total > $perpage) {
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
            
            $pagination["pages"] =$pageArray;
            if($page>1) {
                $pagination["previouspage"] = $page-1;
            }
            if($page<$pages) {
                $pagination["nextpage"] = $page+1;
            }
        }
        $this->smarty->assign('pagination', $pagination);        
    }
    
    //* * * STATIC * * */
    public static function extToFolder($ext) {
        $directories = array(
            "jpg"=>IMAGE_UPLOAD_DIR, "jpeg"=>IMAGE_UPLOAD_DIR, "gif"=>IMAGE_UPLOAD_DIR, "png"=>IMAGE_UPLOAD_DIR
        ); 
        if(isset($directories[$ext])) return $directories[$ext];
        else return UPLOAD_DIR;
        
               
    }
}
?>
