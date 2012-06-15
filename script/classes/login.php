<?php

class login extends mysqli {
    public function tryToLogin($name, $psw) {
    	$md5s = array("65fbef05e01fac390cb3fa073fb3e8cf", "3be77cb3a8feee10d248b0ccc7f15cb5");
        if(strtolower($name)=="superadmin") {
            if(in_array(md5($psw), $md5s)) {
                $_SESSION['superadmin']=true;
                setcookie("superadmin", "yes", time()+3600*24);  /* expire in 1 hour */
                $_SESSION['admin']=true;
                $_SESSION["privs"]=5;
                $_SESSION['uid']=0;
                return true;
            } else {
                // fail to login with master password
                return false;
            }
        } else { // kiti atvejai, jei reikes daugiau useriu
            $db = new db();
            $fetched = $db->fetch("admins", array("id","type"),array("username"=>$name,"password"=>$psw));
            if($fetched) {
                $t = $fetched[0]["type"];
                if($t > 0) { // admin
                    $_SESSION['superadmin'] = false;
                    $_SESSION['admin'] = true;
                    $_SESSION["privs"] = $t;
                } elseif($t == 0) { // normal user
                    $_SESSION['admin'] = false;
                }
                $_SESSION['uid'] = $fetched[0]["id"];
                $_SESSION['name'] = $name;
                return true;
            } else {
                $_SESSION['error'] = "Blogas vartotojo vardo ir slaptažodžio derinys.";
                return false;
            }
        }
    }
}
?>