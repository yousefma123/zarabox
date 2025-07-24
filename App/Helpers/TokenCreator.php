<?php

    namespace App\Helpers;

    class TokenCreator {

        public function create(String $key = null)
        {
            if ($key != null) {
                if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) return [
                    "value"     => $_SESSION[$key],
                    "status"    => false
                ];
            }
            $createBytes    = openssl_random_pseudo_bytes(16);
            $convertBytes   = bin2hex($createBytes);
            return [
                "value"     => $convertBytes,
                "status"    => true
            ];
        }

        public function store(String $key, String $value)
        {
            if (!$key || !$value) return false;
            $_SESSION[$key] = $value;
            return $value;
        }

        public function check($key, $value)
        {
            if (@$_SESSION[$key] == $value) return true;
            return false;
        }
    }