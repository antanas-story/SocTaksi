<?php
class Model {
    public $db;
    public $admin = false;
    public $lastop;
    public $afterEdit = "list";
    
    public function __construct($db) {
        if( (isset($this->requiredprivs)&&$_SESSION["privs"]==$this->requiredprivs) || !isset($this->requiredprivs) || (isset($_SESSION["superadmin"])&&$_SESSION["superadmin"]) ) {
            $this->db = $db;
        } else {
            die('Nepakankamos privilegijos.');
        }
        
    }
    public function fetch($where=NULL, $order=NULL, $limit=NULL) {
        if(isset($this->safeDelete)&&$this->safeDelete)
            $where["deleted"] = 0;
        $data = $this->db->fetch($this->tableName, "*", $where, $order, $limit);
        if(is_array($data)&&method_exists($this, "fetchFilter")) {
            foreach($data as $key=>$val) {
                $data[$key] = $this->fetchFilter($val);
            }
        }
        return $data;
    }
    public function count($where) {
        if(isset($this->safeDelete)&&$this->safeDelete)
            $where["deleted"] = 0;
        $data = $this->db->fetch($this->tableName, array("COUNT(*) as count"), $where);
        if(!empty($data))
            return $data[0]["count"];
        else return 0;
    }
    public function fetchAll($orderby=NULL, $ascdesc="asc", $limit=NULL, $where=NULL) {
        if($orderby==NULL) {
            $order = is_array($this->defaultSort) ? $this->defaultSort : array($this->defaultSort=>$ascdesc); 
        } else {
            $order = array($orderby=>$ascdesc);
            if($orderby!=$this->defaultSort) {
                if(is_array($this->defaultSort)) {
                    $order = array_merge($order, $this->defaultSort);
                } else { 
                    $order[$this->defaultSort] = "asc";
                }
            }
        }
        if(isset($this->safeDelete)&&$this->safeDelete)
            $where["deleted"] = 0;        
        $data = $this->fetch($where, $order, $limit);
        if(is_array($data)&&method_exists($this, "fetchFilter")) {
            foreach($data as $key=>$val) {
                $data[$key] = $this->fetchFilter($val, true);
            }
        }
        return $data;
    }
    public function fetchKeyId($orderby=NULL, $ascdesc="asc", $limit=NULL, $where=NULL) {
        $data = $this->fetchAll($orderby, $ascdesc, $limit, $where);
        $output = array();
        if(!empty($data))
            foreach($data as $key=>$val) {
                $output[$val["id"]] = $val;
            }
        return $output;
    }
    public function fetchById($id, $whereField = "id") {
        list($data) = $this->db->fetch($this->tableName, "*", array($whereField=>$id));
        if(!empty($data)&&method_exists($this, "fetchFilter")) {
            $data = $this->fetchFilter($data);
        }
        return $data;
    }
    public function search($query=NULL, $where="name", $orderby=NULL, $ascdesc="asc") {
        if($orderby==NULL) $orderby = $this->defaultSort;
        if(empty($query)) { 
            $w = $where;
        } else {
            $w = array($where=>array("LIKE"=>"%".$query."%") );
        }
        $data = $this->db->fetch($this->tableName, "*", $w, array($orderby=>$ascdesc));
        return $data;
    }
    public function add($fieldsorig) {
        $fields = $fieldsorig;
        if(method_exists($this, "dataFilter")) {
            $fields = $this->dataFilter($fields, true);
        }
        $bool = $this->db->update($this->tableName, $fields);
        $id = $this->db->lastinserted;
        if(method_exists($this, "picAction")) {
            $this->picAction($id, $fieldsorig);
        }
        return $bool;
    }
    public function set($id,$fieldsorig) {
        $fields = $fieldsorig;
        if(method_exists($this, "dataFilter")) {
            $fields = $this->dataFilter($fields);
        }
        $bool = $this->db->update($this->tableName, $fields, array("id"=>$id));
        if(method_exists($this, "picAction")) {
            $this->picAction($id, $fieldsorig);
        }        
        return $bool;
    }    
    public function del($id) {
        if(isset($this->safeDelete)&&$this->safeDelete) {
            return $this->db->update($this->tableName, array("deleted"=>1), array("id"=>$id));
        } else {
            return $this->db->delete($this->tableName, array("id"=>$id));
        }
        
    }    
    public function slug($string) {
        $from = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', "Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
        $to   = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia', "A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");
        
        $str = strtolower(trim(str_replace($from, $to, $string)));
        $str = strip_tags($str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);   
        return trim($str, "-");
    }
    public function makePicThumb($picid, $width="", $height="") {
        $pic = $this->db->fetch("pics", array("filename"), array("id"=>$picid));
        $filename = "./imgs/".$pic[0]["filename"];
        if(file_exists($filename)&&!is_dir($filename)) {
            $img = new Image($filename);
            if($img->height > MAX_PICTURES_HEIGHT) {
                $img->resizeImg(0, MAX_PICTURES_HEIGHT);
            }
            $img->makeThumb(empty($width) ? PICTHUMB_WIDTH : $width, empty($height) ? PICTHUMB_HEIGHT : $height, "thumbs/".$picid, "gif", "crop");
        }
        
    }
}
?>
