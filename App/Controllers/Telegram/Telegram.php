<?php

namespace App\Controllers\Telegram;
require_once __DIR__ . '/../../../shared/bootstrap.php';

use App\Database\Connection;
use App\Helpers\Statement;

class Telegram
{
    protected $conn;
    private string $botToken;
    private string $chatId;
    private string $apiUrl;

    public function __construct()
    {
        $this->conn  = (new Connection())->DB;

        $this->botToken = $_ENV['TELEGRAM_BOT_TOKEN'];
        $this->chatId   = $_ENV['TELEGRAM_RECEIVER_ID'];
        $this->apiUrl   = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
    }

    public function newOrder(string $message)
    {
        $data = [
            'chat_id' => $this->chatId,
            'text'    => $message,
            'parse_mode' => 'HTML',
            'disable_notification' => false,
            'disable_web_page_preview' => true
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data),
                'timeout' => 10
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, false, $context);
        file_put_contents('telegram_message_debug.txt', $message);


        return $result !== false;
    }
}