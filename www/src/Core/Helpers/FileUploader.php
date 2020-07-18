<?php


namespace App\Core\Helpers;


use App\Core\Request\Request;
use Exception;

abstract class FileUploader
{

    #region field
    /** @var string */
    private static $rootPath = ROOT_PATH. "/public/assets/images/uploads";

    /** @var string */
    private static $rootUri = "/assets/images/uploads";

    /**
     * @var
     */
    private static $file;

    /**
     * @var int
     */
    private static $maxUpload = 100000000;

    /** @var string[]  */
    private static $extAllowed = [
        "7z","aiff","asf","avi","bmp", "blob","csv","doc","docx","fla","flv","gif","gz","gzip","jpeg","jpg","mid","mov","mp3","mp4",
        "mpc","mpeg","mpg","ods","odt","pdf","png","ppt","pptx","pxd","qt","ram","rar","rm","rmi","rmvb","rtf","sdc", "svg","sitd","swf",
        "sxc","sxw","tar","tgz","tif","tiff","txt","vsd","wav","wma","wmv","xls","xlsx","zip"];

    /**
     * @var string[]
     */
    private static $allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");

    #endregion

    /**
     * @param array $file
     * @param string $dir
     * @return string
     * @throws Exception
     */
    public static function UploadFile(array $file, string $dir = "/"): string
    {

        $fileTab = explode(".", $file["name"]);
        $ext = array_pop($fileTab);

        // Validate uploaded files.
        // Do not use $_FILES["file"]["type"] as it can be easily forged.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmpName = $file["tmp_name"];

        // Get mime type.
        $mimeType = finfo_file($finfo, $tmpName);

        if(!in_array($ext, self::$extAllowed) || !in_array(strtolower($mimeType), self::$allowedMimeTypes) ) throw new Exception("Extention not allowed");

        if($file["size"] > self::$maxUpload) throw new Exception("File too heavy");

        $fileName = md5($file["name"]).".$ext";

        if(strlen($dir) > 1){
            $dir = rtrim($dir, "/");
        }

        move_uploaded_file($tmpName, self::$rootPath.$dir.$fileName);

        return self::$rootUri.$dir.$fileName;
    }
}