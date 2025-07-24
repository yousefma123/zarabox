<?php

    namespace App\Helpers;

    class Uploader { 

        public function index(Array $file_array, String $src, Int $size_allowd, Array $types_allowed, $check_before = false, $check_ext = true) 
        :Array 
        {   
            $status = [];

            $file_name  = strtolower($file_array['name']);
            $cut_file   = explode('.', $file_name);
            $file_type  = end($cut_file);
            if($check_ext == true){
            if(in_array($file_type, $types_allowed))
                {
                    if($file_array['size'] > $size_allowd)
                    {
                        $status['type']     = "error";
                        $status['message']  = "حجم الملف كبير للغاية";
                    }
                }else{
                    $status['type']     = "error";
                    $status['message']  = "برجاء رفع ملف مطابق للأنواع المسموح بها";
                }
            }

            if(empty($status)){
                if($check_before == false){
                    $random_file_name = bin2hex(openssl_random_pseudo_bytes(8)).time().'.'.$file_type;
                    if(move_uploaded_file($file_array['tmp_name'], dirname(__DIR__).$src.$random_file_name)){
                        $status['type']       = "success";
                        $status['message']    = true;
                        $status['file_name']  = $random_file_name;
                    }
                }else{
                    $status['type']     = "success";
                    $status['message']  = true;
                    $status['file']     = $file_array;
                }
            }
            
            return $status;
        }

    }