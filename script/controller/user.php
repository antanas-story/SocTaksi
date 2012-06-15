<?php
class User extends UserCore{

    protected $facebookurl = "http://www.facebook.com/pages/Daily-Card/153049091376412";
    protected $defaulturl = "titulinis";    
    protected $lang = "lt";
    
    
    protected function ajaxifyTpl($tpl) {
    	if($tpl=="send"&&isset($_GET['ajax'])&&!empty($_POST)) {
    		die( $this->submitEmail() );
    		
    	}
        return $tpl;
    } 
    protected function commonNoCache() {
        if(!empty($_SESSION['u'])) {
        	$this->smarty->assign("user", $_SESSION['u']);
        }
        date_default_timezone_set("Europe/Helsinki"); 
    	setlocale(LC_ALL, 'lt_LT.UTF8');
    }
    protected function common() {
        // paths
        $this->smarty->assign('path', $this->absolutepath);
    }
    protected function auth(&$tpl, $whoGoesInside="") {
    	$fail = false;
    	$who = (array) $whoGoesInside;
    	if(empty($whoGoesInside)) {
    		if(!isset($_SESSION['u']))
    			$fail = true;
    	} elseif(!in_array($_SESSION['u']['type'], $who)) {
    		$fail = true;
    	}
    	if($fail) {
    		header("HTTP/1.0 403 Forbidden");
			$tpl = "forbidden";
    	} 
    }
    protected function determineTpl($pieces) {
    	$p = &$pieces[0];
        if($p=="admin") {
            header("Location: {$this->absolutepath}admin.php");
        }
        if(empty($p) || $p == "titulinis") {
            $tpl = "titular";
        } elseif($p == "siusti") {
            $tpl = "send";
        } elseif($p == "naujienos") {
            $tpl = "news";
        } elseif($p == "registracija") {
            $tpl = "register";
        } elseif($p == "rezervuoti") {
            $tpl = "reserve"; $this->auth($tpl);
        } elseif($p == "nustatymai") {
        	$tpl = "settings"; $this->auth($tpl, "client");
        } elseif($p == "statistika") {
        	$tpl = "statistics"; $this->auth($tpl, "admin");
        } elseif($p == "uzsakymai") {
        	if( isset($_SESSION['u']['type']) && $_SESSION['u']['type']=="client") {
        		$tpl = "orders-client";
        	} else {
        		$tpl = "orders";
        	}
        	$this->auth($tpl);
        	
        } elseif($p == "vartotojai") {
        	$tpl = "users";$this->auth($tpl, "admin");
        } elseif($p == "admin") {
        	header("Location: ".$this->absolutepath."admin.php");
        } elseif($p == "login") {
        	$this->login();
        } elseif($p == "logout") {
        	unset($_SESSION['u']);
        	header("Location: ".$this->absolutepath);
        } else {
        	$cObj = new Content($this->db);
        	$page = $cObj->fetchById($p, "slug");
        	if(!empty($page)) {
        		$tpl = "simple";
        	} else {
	            header("HTTP/1.0 404 Not Found");
	            $tpl = "notfound";
        	}
        }
        return $tpl;
    }
    
    /* TEMPLATE SPECIFIC */
    protected function generalTemplate(&$tpl, $urlpieces) { 
        $href = $urlpieces[0];
        if($tpl == "titular") {
        	$cObj = new Content($this->db);
        	$titular = $cObj->fetchById("tituliniame-kaireje", "slug");
        	$this->smarty->assign('titular', $titular);
        	$href="";
            /*$picturesObj = new Pictures($this->db);
            $pictures = $this->db->q("SELECT pics.* FROM {p}pictures as pics, {p}categories as cats WHERE pics.cat = cats.id AND cats.slug_lt = 'titulinis' ORDER BY RAND() LIMIT 0,1");
            $mainpic = isset($pictures[0]) ? $pictures[0]["filename"] : "";
            $this->smarty->assign('mainpic', $mainpic);*/
        } elseif($tpl=="reserve") {
        	$data = $_POST;
        	$time = $data["date"]." ".$data["time"];
        	//dump($data);
        	$this->smarty->assign('data', $data);
        	//$availableDrivers = $this->availableDrivers($time);
        	
        	if($this->isTimeAvailable($time)) {
        		if(!empty($urlpieces[1]) && $urlpieces[1]=="patvirtinti") {
        			$now = date("Y-m-d H:i:s");
        			$fields = array( 
        				'client'=>$_SESSION['u']['id'],
        				'when'=>$time,
        				'created'=>$now,
        				'changed'=>$now,
        				'addressFrom'=>$_POST['address'],
        				'addressTo'=>$_POST['addressTo'],
        				'backOn'=>$_POST['backOn'],
        				'extra'=>$_POST['extra']
        			);
        			$this->db->update("orders", $fields);
        			$tpl .= "d";
        		} else {
        			$tpl .= "confirm";
        		}
        	} else {
	        	$tpl .= "taken";
	        	$lookahead = 30 *24*60*60; // look ahead 30 days
	        	$ts = time();
	        	$currentDay = mktime(0, 0, 0, date("n", $ts), date("j", $ts), date("Y", $ts));
	        	$orders = $this->db->q("SELECT * FROM {p}orders WHERE `when` > '".date("Y-m-d H:i:s", $currentDay)."'");
	        	$grouped = array();
	        	for($i=0; $i<30; $i++) {
	        		$day = mktime(0, 0, 0, date("n", $ts), date("j", $ts)+$i, date("Y", $ts));
	        		$grouped[ date("Y-m-d", $day) ] = array();
	        	}
	        	
	        	if(!empty($orders))
		        	foreach($orders as $o) {
		        		$grouped[date("Y-m-d", strtotime($o["when"]))][] = $o;
		        		
		        	}
	        	$this->smarty->assign("orders", $grouped);
        	}
        } elseif($tpl=="users") {
        	if(!empty($_POST['u'])) {
        		unset($_POST['u']['confirmpassword']);
        		if(empty($_POST['u']['password']))
	        		unset($_POST['u']['password']);
        			
        		if(isset($_POST['u']['id'])) {
        			$id = $_POST['u']['id'];
        			unset($_POST['u']['id']);
        			$this->db->update("users", $_POST['u'], array("id"=>$id));
        		} else {
        			$this->db->update("users", $_POST['u']);
        		}
        	}
        	if(!empty($urlpieces[1])) {
        		$tpl = "userform";
        		if($urlpieces[1]=="keisti"&&!empty($urlpieces[2])) {
        			$id = $urlpieces[2];
        			list($user) = $this->db->q("SELECT * FROM {p}users WHERE deleted=0 AND id=?", $id);
        			$this->smarty->assign('data', $user);
        		} elseif($urlpieces[1]=="trinti") {
        			if($urlpieces[2]!=$_SESSION['u']['id'])
						$this->db->q("UPDATE {p}users SET deleted=1 WHERE type!='admin' AND id=?", $urlpieces[2]);
						
					header("Location: ".$this->absolutepath."vartotojai");
        		}
        		//dump($this->db->lasterror);
        		//dump($this->db->lastquery);
        	} else {
	        	$q ="SELECT u.*, count(o.id) as count ".
	        		"FROM {p}users as u LEFT JOIN {p}orders as o ON (u.id = o.driver OR u.id = o.client) ".
	        		"WHERE u.deleted=0 GROUP BY u.id ".
	        		"ORDER BY u.type DESC, u.lastname ASC";
	        	$users = $this->db->qKey(array("type", "id"), $q);
	        	$this->smarty->assign('clients', $users["client"]);
	        	$this->smarty->assign('drivers', $users["driver"]);
	        	$this->smarty->assign('admins', $users["admin"]);
        	}
        } elseif($tpl=="orders-client") {
        	$now = date("Y-m-d H:i:s");
        	if(isset($urlpieces[1]) && $urlpieces[1]=="istorija") { 
        		$w = "<="; $current = false;
        	} else $w = ">"; 
        	$q ="SELECT o.*, u.firstname, u.lastname, u.phone ".
        		"FROM {p}orders as o ".
        		"LEFT JOIN {p}users as u ON (u.id = o.driver) ".
	        		"WHERE o.client = ? ".
	        		"ORDER BY o.when DESC";
        		//"WHERE o.client = u.id AND o.when {$w} '$now' ".
        		//"ORDER BY o.status ASC, o.when ASC";        	
        	$orders = $this->db->q($q, $_SESSION['u']['id']);
        	$this->smarty->assign('orders', $orders);
        	$this->smarty->assign('now', time());
        	
        	//dump($orders, 'orders');
        	//dump($this->db->lasterror, 'dberr');
        	//dump($this->db->query, 'dbq');
        } elseif($tpl=="orders") {
        	$now = date("Y-m-d H:i:s"); $current = true;
        	if(isset($_POST['status'])) {
        		$this->db->update("orders", array("changed"=>$now, "driver"=>$_SESSION['u']['id'], "status"=>$_POST['status']), array("id"=>$_POST['id']));
        	}
        	
        	if(isset($urlpieces[1]) && $urlpieces[1]=="istorija") { 
        		$w = "<="; $current = false; $o = "DESC";
        	} else { $w = ">"; $o = "ASC"; } 
        	$q ="SELECT o.*, u.firstname, u.lastname, u.contract, u.phone ".
        		"FROM {p}orders as o, {p}users as u ".
        		"WHERE o.client = u.id AND o.when {$w} '$now' ".
        		"ORDER BY o.when {$o}";        	
        	$orders = $this->db->q($q);
        	$this->smarty->assign('orders', $orders);
        	$this->smarty->assign('current', $current);
        	
        	if(isset($_GET['ajax'])) $tpl = "orderlist";
        } elseif($tpl=="statistics") {
        	$this->statistics();
        } elseif($tpl=="simple") {
        	$cObj = new Content($this->db);
        	$page = $cObj->fetchById($href, "slug");
        	$this->smarty->assign('page', $page);
        } elseif($tpl=="register") {
        	$cObj = new Content($this->db);
        	$page = $cObj->fetchById($href, "slug");
        	$this->smarty->assign('page', $page);
        } elseif($tpl=="news") {
        	$newsObj = new News($this->db);
        	$news = $newsObj->fetchAll();
        	if(!empty($urlpieces[1])&&$urlpieces[1]=="rss") {
        		header("Content-Type: application/rss+xml; charset=UTF-8"); 
	        	$this->smarty->assign('dateformat', DateTime::RSS);
        		$tpl = "news-rss";
        	} elseif(!empty($urlpieces[1])) {
        		$article = $newsObj->fetchById($urlpieces[1], "slug");
        		if(!empty($article)) {
        			$this->smarty->assign('article', $article);
        			$tpl = "news-article";
        		}
        	}
        	$this->smarty->assign('news', $news);
        }
        $this->smarty->assign("href", $href);
    }                 
    protected function statistics() {
    	$totalClients = $this->count("users", array("deleted"=>0, "type"=>"client"));
    	$this->smarty->assign("totalUsers", $totalClients);
    	
    	$orders = $this->db->qKey("status", "SELECT count(id) as count, status FROM {p}orders GROUP BY status");
    	$functionMakeSimple = create_function('$e','return $e["count"];');
    	$orders = array_map($functionMakeSimple, $orders);
    	$this->smarty->assign("orders", $orders);
    	
    	$w = array(
    		"status"=>array("new", "accepted"),
    		"when"=>array(">="=>date("Y-m-d H:i:s"))
    	);
    	$ongoingOrders = $this->count("orders", $w);
    	$this->smarty->assign("ongoingOrders", $ongoingOrders);
    	
    	$timeFromStart = time() - strtotime(PROJECT_STARTED_ON);
    	
    	$ordersPerDay = (24*60*60 * $orders["accepted"]) / $timeFromStart;
    	$this->smarty->assign("ordersPerDay", $ordersPerDay);
    	
    	$ordersPerMonthPerUser = (24*60*60*30 * $orders["accepted"]) / ($timeFromStart * $totalClients);
    	$this->smarty->assign("ordersPerMonthPerUser", $ordersPerMonthPerUser);
    	
    	//PROJECT_STARTED_ON
//     	dump($orders);
//     	dump($this->db->lasterror);
    }
    /* END TEMPLATE SPECIFIC */
    
    /* ACTION FUNCTIONS */
    protected function login() {
    	$return = 0;
    	if(!empty($_REQUEST['email']) && !empty($_REQUEST['password'])) {
    		list($user) = $this->db->q("SELECT * FROM {p}users WHERE email = ? AND password = ? AND deleted=0", $_REQUEST['email'], $_REQUEST['password']);
    		if(!empty($user)) {
    			$_SESSION['u'] = $user;
    			$return = 1;
    		}
    	}
    	
    	echo $return; die;
    }
    protected function submitEmail() {
		if($this->validateEmail($_POST['email'])) {
			$message = "Sveiki,\n\n".
				"socialinistaksi.lt tinklapyje užsiregistravo {$_POST['firstname']} {$_POST['lastname']}, el. paštas {$_POST['email']}\n\n".
				"Papildoma informacija: {$_POST['extra']}";
			
			$to      = "zmogus@zmogui.lt";
			$subject = "socialinistaksi.lt nauja registracija";
			$headers = 'From: '.$_POST['email'] . "\r\n" .
			    'Reply-To: '.$_POST['email'] . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();	
					
			return mail($to, $subject, $message, $headers);
		}    	
    }
    /* END ACTION FUNCTIONS */
    
    /* HELPER FUNCTIONS */
    protected function availableDrivers($time) {
    	$tolerance = 30 * 60; // 30 minutes
    	$ts = strtotime($time);
    	// hour, minute, second, month, day, year
    	$from = date("Y-m-d H:i:s", $ts-$tolerance); // mktime(date("H", $ts), date("i", $ts)-tolearnce, date("s", $ts), date("n", $ts), date("j", $ts), date("Y", $ts));
    	$until = date("Y-m-d H:i:s", $ts+$tolerance); // mktime(date("H", $ts), date("i", $ts)+tolearnce, date("s", $ts), date("n", $ts), date("j", $ts), date("Y", $ts));
    
    	$takenDrivers =
    	"SELECT o.driver ".
    	"FROM {p}orders as o ".
    	"WHERE o.when > '$from' AND o.when < '$until'";
    	$query =
    	"SELECT u.* ".
    	"FROM {p}users as u ".
    	"WHERE u.type='driver' AND deleted=0 AND u.id NOT IN ($takenDrivers)";
    	$drivers = $this->db->q($query);
    	/*dump($drivers);
    	 dump($this->db->lasterror);
    	dump($this->db->lastquery);*/
    	if(empty($drivers)) return false;
    	else return $drivers;
    }
    protected function isTimeAvailable($time) {
    	$tolerance = 30 * 60; // 30 minutes
    	$ts = strtotime($time);
    	// hour, minute, second, month, day, year
    	$from = date("Y-m-d H:i:s", $ts-$tolerance); // mktime(date("H", $ts), date("i", $ts)-tolearnce, date("s", $ts), date("n", $ts), date("j", $ts), date("Y", $ts));
    	$until = date("Y-m-d H:i:s", $ts+$tolerance); // mktime(date("H", $ts), date("i", $ts)+tolearnce, date("s", $ts), date("n", $ts), date("j", $ts), date("Y", $ts));
    
    	$conflictingOrderCount =
    	"SELECT count(o.id) as count ".
    	"FROM {p}orders as o ".
    	"WHERE o.status != 'rejected' AND o.when > '$from' AND o.when < '$until'";
    	$driverCount =
    	"SELECT count(u.id) as count ".
    	"FROM {p}users as u ".
    	"WHERE u.type='driver' AND deleted=0";
    	list($conflictingOrders) = $this->db->q($conflictingOrderCount);
    	list($drivers) = $this->db->q($driverCount);
    	return $conflictingOrders["count"] < $drivers["count"];
    }    
    protected function validateEmail($email) {
        if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
                list (, $domain)  = explode('@', $email);
                if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {
                    return true;
                }
        }
        return false;
    }    
    /* END HELPER FUNCTIONS */
}
?>
