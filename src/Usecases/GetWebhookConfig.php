<?php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

function ymtp_getWebhookConfig(
    string $access_token
) {
    try {
        $httpClient = new Client();

        $response = $httpClient->get(
            $GLOBALS['yumit_merchants_api'] . '/webhook',
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                ],
            ]
        );
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    } catch (\Throwable $th) {
        echo esc_html($th->getMessage());
    }
}
