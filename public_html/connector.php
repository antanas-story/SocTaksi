<?php
session_start();

// Required: anonymous function number as explained above.
$funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load specific configuration file or anything else)
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages
$langCode = $_GET['langCode'] ;

$uploadpath = "uploads/editor/";

require_once 'default.php';

$admin = new Admin;

$message = '';
$fname = '';
if(isset($_FILES["upload"])) {
    if($_FILES["upload"]["error"] == 0) {
        $name = $_FILES["upload"]["name"];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $i = 0;
        do {
            $i++;
            $tmp = $i > 1 ? "_".$i : "";
            $newfname = pathinfo($name, PATHINFO_FILENAME).$tmp.".".$extension;
            $path = $uploadpath.$newfname;
        } while (file_exists($path));
        
        if (!@move_uploaded_file($_FILES["upload"]["tmp_name"], $path)) {
            $message = FILE_UPLOAD_ERR." $path";
        } else {
            $fname = ABSOLUTE_PATH.$uploadpath.$newfname;
            if($arr = getimagesize($fname)) {
                list($width, $height, $type, $attr) = $arr;
                if($height>MAX_PICTURES_HEIGHT) {
                    $img = new Image($fname);
                    $img->resizeImg(0, MAX_PICTURES_HEIGHT);
                }
            }
            
        }
    } else {
        if($_FILES["upload"]["error"]!=4)
            $message = FILE_UPLOAD_ERR.constant("UPLOAD_ERR_".$_FILES["upload"]["error"]);
    }

}
 
/* ["pictures"])) {
    foreach($_FILES["pictures"]["name"] as $key => $fname) {
    }
}*/
// Check the $_FILES array and save the file. Assign the correct path to some variable ($url).
// Usually you will assign here something only if file could not be uploaded.
//dump($_FILES);
if(!empty($fname))
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '".$fname."');</script>";
else
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, null, '$message');</script>";
?>