<?php

/* PATHS */
define("BASE", "/home/zmoguilt/domains/socialinistaksi.lt");
define("ROOT", BASE.'/script');
define("PUBLIC_HTML_PATH", BASE.'/public_html');
define("PATH_TO_SMARTY", BASE.'/smarty/libs/Smarty.class.php');
define("SMARTY_TEMPLATE_DIR", ROOT.'/templates/web');
define("SMARTY_LOGIN_TEMPLATE_DIR", ROOT.'/templates/login');
define("SMARTY_ADMIN_TEMPLATE_DIR", ROOT.'/templates/admin');
define("SMARTY_COMPILE_DIR", BASE.'/smarty/templates_c');
define("SMARTY_CACHE_DIR", BASE.'/smarty/cache');
define("SMARTY_CONFIG_DIR", BASE.'/smarty/configs');
define("ABSOLUTE_PATH", "http://socialinistaksi.lt/");
define("IMAGE_UPLOAD_DIR", "images");
define("UPLOAD_DIR", "uploads");

/* SITE SPECIFIC */
define("PROJECT_STARTED_ON", "2012-06-01 00:00:00");
                                                                                                  
/* ADMIN PANEL */
define('FILE_UPLOAD_ERR', 'Klaida įkeliant failą. ');
define('UPLOAD_ERR_BAD_EXT', "Priimami tik .jpg, .jpeg, .png ir .gif formatai");
define('UPLOAD_ERR_1', "Failas viršyja leistino dydžio reikalavimus nusakytus php konfiguracijoje");
define('UPLOAD_ERR_2', "Failas viršyja leistino dydžio reikalavimus");
define('UPLOAD_ERR_3', "Failas buvo įkeltas tik dalinai");
define('UPLOAD_ERR_4', "Nenurodėte failo");
define('UPLOAD_ERR_6', "Nerastas laikinas folderis");

define('FAIL_MSG_SET', 'Nepavyko redaguoti');
define('FAIL_MSG_ADD', 'Nepavyko sukurti');
define('FAIL_MSG_DEL', 'Nepavyko ištrinti');
define('SUC_MSG_SET', 'Sėkmingai redagavome');
define('SUC_MSG_ADD', 'Sėkmingai sukūrėme');
define('SUC_MSG_DEL', 'Sėkmingai ištrynėme');  

define('HOMEPAGE_LOC', 'Pradžia');
define('EDIT_LOC','redagavimas');
define('NEW_LOC','kūrimas');

define('ACTION_NEW','Įrašyti');
define('ACTION_EDIT','Redaguoti');

?>
