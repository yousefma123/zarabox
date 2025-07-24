<?php

    namespace App\Helpers;

    class TokenCreator {

        public function __construct()
        {
            $createBytes    = openssl_random_pseudo_bytes(16);
            $convertBytes   = bin2hex($createBytes);
            return $convertBytes;
        }

    }