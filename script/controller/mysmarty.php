<?php
require_once PATH_TO_SMARTY;

class MySmarty extends Smarty {
    public function __construct() {
        parent::__construct();        
        $this->template_dir = SMARTY_TEMPLATE_DIR;
        $this->compile_dir = SMARTY_COMPILE_DIR;
        $this->cache_dir = SMARTY_CACHE_DIR;
        $this->config_dir = SMARTY_CONFIG_DIR;
        $this->registerPlugin("modifier", 'ucfirst', 'ucfirst');
        $this->registerPlugin("modifier", 'round', 'round');
        $this->registerPlugin("function", 'digest', 'smarty_digest');
        $this->registerPlugin("function", 'count', 'smarty_count');
        $this->registerPlugin("modifier", 'title', 'smarty_title');
        $this->registerPlugin("modifier", 'timestamp', 'smarty_timestamp');
        $this->registerPlugin("modifier", 'striptags', 'strip_tags');
        $this->registerPlugin("modifier", 'striptags_p', 'smarty_striptags_p');
        $this->registerPlugin("block", 'dynamic', 'smarty_block_dynamic', false);
        $this->registerPlugin("function", 'limit', 'smarty_limit');                            

/*        $this->caching = 2;
        $this->cache_lifetime = 60;*/
    }   
}
function smarty_striptags_p($input) {
    $out = preg_replace("/<[\/]?p[^>]{0,}\>/i", "", $input); 
    return $out;
}
function smarty_digest($params, &$smarty) {
    $data = $params["string"];
    unset($params["string"]);
    foreach($params as $param=>$val) {
        $data = str_replace("{".$param."}", $val, $data);
    }
    return $data;
}

function smarty_limit($params, &$smarty) {
    $return = "";
    if(!empty($params['string'])) {
        if(!empty($params['length'])) {
            $start = empty($params["start"]) ? 0 : intval($params["start"]);
            $return = substr($params['string'],$start, intval($params['length']));
        }
    }
    return $return;
}

function smarty_count($params, &$smarty) {
    return count($params["array"]);
}

function smarty_timestamp($time) {
    return strtotime($time);
}

function smarty_title($title) {
    return "Daily Card. ".$title;
}
function smarty_block_dynamic($param, $content, &$smarty) {
    return $content;
}
?>
