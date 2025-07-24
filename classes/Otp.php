<?php

    require dirname(__DIR__)."/vendor/autoload.php";
    
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
   
    class Otp {
        public function __construct($phone, $invoiceNumber, $otp)
        {
            $bearer = 'e8295eaf3240e77eceb704c0307f41bc';
            $taqnyt = new TaqnyatSms($bearer);
            $body = "طلبك خرج للتوصيل من شركة ألواح الخليج ( تكنو بوند )، رمز التحقق الخاص بك هو $otp يرجى عدم مشاركته، وتسليمه لمندوب التوصيل حين وصوله إليك.";
            $recipients = [$phone];
            $sender = 'AlwahKhalej';
            
            $message =$taqnyt->sendMsg($body, $recipients, $sender);
        }
    }
