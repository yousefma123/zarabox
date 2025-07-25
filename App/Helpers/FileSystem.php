<?php 

    namespace App\Helpers;

    class FileSystem {

        public function remove($src)
        {
            if(file_exists($src)){
                return unlink($src);
            }
        }

    }