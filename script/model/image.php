<?php
class Image {
    protected $filename;
    protected $extension;
    protected $dir;
    protected $path;
    public $width;
    public $height;
    public $type;
    public $attr;
    

    public function __construct($path) {
        if(file_exists($path)) {
            $this->path = $path;
            $path_parts = pathinfo($path);
            $this->dir = $path_parts['dirname'];
            $this->extension = $path_parts['extension'];
            $this->filename = $path_parts['filename'];
            $this->updateDims();
            return true;
        } else { // img not found
            return false;
        }
    }
    protected function updateDims() {
        list ($this->width, $this->height, $this->type, $this->attr) = getimagesize($this->path);
    }
    
    /**
    * Makes a thumbnail
    * 
    * @param int $newWidth Width of the thumb. 0 to keep width proportions
    * @param int $newHeight Height of the thumb. 0 to keep height proportions 
    * @param string $name The filename you want your thumb to have
    * @param string $extension Avaliable extensions 'gif', 'png', 'jpg' (default)
    * @param string $mode The resize mode. 'crop' to crop it or 'fit' to leave fit into dimensions
    */
    public function makeThumb($newWidth, $newHeight, $name, $extension=NULL, $mode="crop") {
        if(empty($extension)) $extension = $this->extension;
        $thumbname = "{$name}.{$extension}";
        $thumbpath = "{$this->dir}/{$thumbname}";
        $this->remakeImg($this->path, $thumbpath, $newWidth, $newHeight, false, $extension, $mode);
        $this->updateDims();
        return $thumbname;
    }
    public function resizeImg($newWidth, $newHeight, $mode="fit") {
        $this->remakeImg($this->path, $this->path, $newWidth, $newHeight, true, $this->extension, $mode);
        $this->updateDims();
    }
    protected function remakeImg($src, $dest, $newW, $newH, $delete = false, $extension="jpg", $mode="crop") {
        $width = $this->width;
        $height = $this->height;
        $type = $this->type;
        $attr = $this->attr;
        if(empty($extension)) {
            $extension = $this->extension;
        }        
        
        if ($newW==0) {
            $newW = floor(($width*$newH)/$height);
        }
        if ($newH==0) {
            $newH = floor(($height*$newW)/$width);
        }
        $setWidth = $width;
        $setHeight = $height;
        $x = 0;
        $y = 0;
        if($mode=="fit") {
            if($width>$height) {
                $newH = floor(($height*$newW)/$width);
            } else {
                $newW = floor(($width*$newH)/$height);
            }
        } else {
            if (round($newW/$newH,3)!=round($width/$height,3)) {
                if (round($newW/$newH,3)>round($width/$height,3)) {
                    if ($width>$newW) {
                        
                        $x = 0;
                        $setWidth = $width;
                        $setHeight = floor($newH*$width/$newW);                    
                        $y = floor(($height-$setHeight)/2);
                    } else {
                        $y = 0;
                        $setHeight = $height;
                        $setWidth = floor($width*$newH/$height);
                        $x = floor(($width-$setWidth)/2);
                    }

                } else {
                    if ($width>$newW) {
                        $y = 0;
                        $setHeight = $height;
                        $setWidth = floor($height*$newW/$newH);
                        $x = floor(($width-$setWidth)/2);
                    } else {
                        $x = 0;
                        $setWidth = $width;
                        $setHeight = floor($newH*$width/$newW);                    
                        $y = floor(($height-$setHeight)/2);                    
                    }
                }
            }
        }
        
        $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'jpg' :
                $im = @imagecreatefromjpeg($src);
            break;
            case 'jpeg' :
                $im = @imagecreatefromjpeg($src);
            break;
            case 'png' :
                $im = @imagecreatefrompng($src);
            break;
            case 'gif' :
                $im = @imagecreatefromgif($src);
            break;
        }
        if(!$im) return false;
        $new_im = imagecreatetruecolor( $newW, $newH );
        imagecopyresampled($new_im, $im, 0, 0, $x, $y, $newW, $newH, $setWidth, $setHeight);
        if($extension=="gif")
            imagegif($new_im, $dest);
        elseif($extension=="png")
            imagepng($new_im, $dest, 0);
        else imagejpeg($new_im, $dest, 100);
        imagedestroy($new_im);
        imagedestroy($im);
        if ($delete&&$src!=$dest) {
            unlink($src);
        }
    
    }
    public function cropImage($x, $y, $newW, $newH, $srcWidth, $srcHeight, $dest, $ext="") {
        $src = $this->path;
        $ext = empty($ext) ? strtolower(pathinfo($this->path, PATHINFO_EXTENSION)) : $ext;
        switch ($ext) {
            case 'jpg' :
                $im = @imagecreatefromjpeg($src);
            break;
            case 'jpeg' :
                $im = @imagecreatefromjpeg($src);
            break;
            case 'png' :
                $im = @imagecreatefrompng($src);
            break;
            case 'gif' :
                $im = @imagecreatefromgif($src);
            break;
        }
        if(!$im) return false;
        $new_im = imagecreatetruecolor( $newW, $newH );
        imagecopyresampled($new_im, $im, 0, 0, $x, $y, $newW, $newH, $srcWidth, $srcHeight);
        if($ext=="gif")
            imagegif($new_im, $dest);
        elseif($ext=="png")
            imagepng($new_im, $dest, 0);
        else imagejpeg($new_im, $dest, 100);
        imagedestroy($new_im);
        imagedestroy($im);
    }    

}
?>