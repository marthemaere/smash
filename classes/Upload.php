<?php
    use Cloudinary\Configuration\Configuration;
    use Cloudinary\Api\Upload\UploadApi;



    /* 
        Upload class to easily upload files to Cloudinary
        Created by @iamgoodbytes
    */  
    class Upload {
        private static $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'svg'];
        private static $fileName;
        private static $fileTempName;
        private static $fileSize;
        private static $fileError;
        private static $fileExtension;

        private static function isExtensionAllowed($extention){
            if(in_array($extention, self::$allowedExtensions)) {
                return true;
            }
            else {
                return false;
            }
        }

        public static function upload($file) {
            $config = Configuration::instance();
            $config->cloud->cloudName = 'weareimd';
            $config->cloud->apiKey = '524548632519475';
            $config->cloud->apiSecret = 'ZVsNoMjJ9OYJn7FZInQ9hvJwhIM';
            $config->url->secure = true;



            // prepare file details
            self::$fileName = $file['name'];
            self::$fileTempName = $file['tmp_name'];
            self::$fileSize = $file['size'];
            self::$fileError = $file['error'];
            $fileExt = explode('.', self::$fileName);
            self::$fileExtension = strtolower(end($fileExt)); //check in lowercase

            // check for file errors
            if(self::$fileError){
                throw new Exception("There was an error uploading your file.");
            }

            // check the extension
            if(!self::isExtensionAllowed(self::$fileExtension)) {
                throw new Exception("This file type is not allowed. Only the following file extension are allowed: " . self::getAllowedExtension() );
            }

            // check the filesize
            if(!self::isFileSizeAllowed()){
                throw new Exception("This file is too large. The maximum file size is 2MB.");
            }

            // all is well, let's upload to Cloudinary
            $result = (new UploadApi())->upload(self::$fileTempName, [ 
                "eager" => [
                  ["width" => 500, "height" => 375, "crop" => "lfill", "gravity" => 'north', "resize" => "limit"],
                ]
            ]);

            $uploadResult = [
                "image" => $result['secure_url'],
                "image_thumb" => $result['eager'][0]['secure_url']
            ];
            return $uploadResult;

        }

        private static function isFileSizeAllowed() {
            // check if size is less than 2MB
            if(self::$fileSize < 2097152) {
                return true;
            }
            else {
                return false;
            }
        }

        private static function getAllowedExtension() {
            return implode(", ", self::$allowedExtensions);
        }

    }