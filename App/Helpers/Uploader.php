<?php

    namespace App\Helpers;

    class Uploader { 

        public bool $status     = false;
        public string $message  = '';
        public string $name     = '';

        public function check(array $file, int $allowed_size, array $allowed_types = []): bool 
        {   
            $fileName  = strtolower($file['name']);
            $cutFile   = explode('.', $fileName);
            $fileType  = end($cutFile);

            if (!empty($allowed_types) && !in_array($fileType, $allowed_types)) {
                $this->message = "برجاء رفع ملف مطابق للأنواع المسموح بها";
                $this->status = false;
                return false;
            }

            if ($file['size'] > $allowed_size) {
                $this->message = "حجم الملف كبير للغاية";
                $this->status = false;
                return false;
            }

            $this->status = true;
            return true;
        }

        public function store(array $file, string $src): bool
        {   
            $fileName  = strtolower($file['name']);
            $cutFile   = explode('.', $fileName);
            $fileType  = end($cutFile);

            $random_file_name = bin2hex(openssl_random_pseudo_bytes(8)) . time() . '.' . $fileType;

            $destination = $src . '/' . $random_file_name;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $this->status = true;
                $this->name   = $random_file_name;
                return true;
            }

            $this->status   = false;
            $this->message  = 'Error occured when uploading !';
            return false;
        }
    }
