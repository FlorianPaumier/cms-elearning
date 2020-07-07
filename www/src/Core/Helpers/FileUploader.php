<?php


namespace App\Core\Helpers;


use App\Core\Request\Request;
use Exception;

abstract class FileUploader
{

    /** @var string */
    private static $rootPath = ROOT_PATH. "/public/assets/images";

    /** @var string */
    private static $rootUri = "/assets/images";

    private static $file;

    private static $maxUpload = 100000;

    /** @var string[]  */
    private static $extAllowed = [
        "7z","aiff","asf","avi","bmp","csv","doc","docx","fla","flv","gif","gz","gzip","jpeg","jpg","mid","mov","mp3","mp4",
        "mpc","mpeg","mpg","ods","odt","pdf","png","ppt","pptx","pxd","qt","ram","rar","rm","rmi","rmvb","rtf","sdc","sitd","swf",
        "sxc","sxw","tar","tgz","tif","tiff","txt","vsd","wav","wma","wmv","xls","xlsx","zip"];



    public static function UploadFile(array $file, string $dir = "/"): string
    {
        $fileTab = explode(".", $file["name"]);
        $ext = array_pop($fileTab);

        if(!in_array($ext, self::$extAllowed)) throw new Exception("Extention not allowed");

        if($file["size"] > self::$maxUpload) throw new Exception("File too heavy");

        $fileName = md5($file["name"]).".$ext";

        if(strlen($dir) > 1){
            $dir = rtrim($dir, "/");
        }

        move_uploaded_file($file["tmp_name"], self::$rootPath.$dir."/".$fileName);

        return self::$rootUri.$dir."/".$fileName;
    }

}