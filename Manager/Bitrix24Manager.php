<?php

namespace Predanie\Bitrix24Bundle\Manager;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Bitrix24Manager
{
    private $chatId;

    private $userId;

    private $webHookCode;

    /**
     * Constructor
     * @param string $chatId
     * @param string $userId
     * @param string $webHookCode
     */
    public function __construct($chatId, $userId, $webHookCode)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->webHookCode = $webHookCode;
    }

    /**
     * @param string $message
     * @return string
     */
    public function imMessageAdd($message)
    {
        try {
            $client = new Client();
            $url = 'https://predanie.bitrix24.ru/rest/' . $this->userId . '/' . $this->webHookCode . '/im.message.add/';

            $responseBody = $client->request('POST', $url, [
                'query' => [
                    'CHAT_ID' => $this->chatId,
                    'MESSAGE' => $message,
                    'SYSTEM' => 'N',
                ],
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                ]
            ]);

            $responseBody = $responseBody->getBody()->getContents();

        } catch (GuzzleException $e) {
            $responseBody = $e->getMessage();
        }

        return $responseBody;
    }
}