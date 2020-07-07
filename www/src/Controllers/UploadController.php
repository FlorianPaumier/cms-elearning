<?php


namespace App\Controllers;


use App\Core\Helpers\FileUploader;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use Exception;

class UploadController extends BaseController
{

    public function upload(Request $request)
    {
        try {
            // File Route.
            $fileRoute = "/assets/images/uploads/";

            $fieldname = "file";

            // Get filename.
            $filename = explode(".", $_FILES[$fieldname]["name"]);

            // Validate uploaded files.
            // Do not use $_FILES["file"]["type"] as it can be easily forged.
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            // Get temp file name.
            $tmpName = $_FILES[$fieldname]["tmp_name"];

            // Get mime type.
            $mimeType = finfo_file($finfo, $tmpName);

            // Get extension. You must include fileinfo PHP extension.
            $extension = end($filename);

            // Allowed extensions.
            $allowedExts = array("gif", "jpeg", "jpg", "png", "svg", "blob");

            // Allowed mime types.
            $allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");

            // Validate image.
            if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
                throw new \Exception("File does not meet the validation.");
            }

            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;
            $fullNamePath = ROOT_PATH . "/public". $fileRoute . $name;

            // Check server protocol and load resources accordingly.
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
                $protocol = "https://";
            } else {
                $protocol = "http://";
            }

            // Save file in the uploads folder.
            move_uploaded_file($tmpName, $fullNamePath);

            // Generate response.
            $response = new \StdClass;
            $response->link = $protocol.$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"]).$fileRoute . $name;

            // Send response.
            return stripslashes(json_encode($response));

        } catch (Exception $e) {
            // Send error response.
            echo $e->getMessage();
            http_response_code(500);
        }
    }
}