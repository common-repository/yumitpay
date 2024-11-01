<?php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

function ymtp_deleteWebhookConfig(
    string $access_token,
    string $webhook_id
) {
    try {
        $httpClient = new Client();
        $data = array(
            "webhookId" => $webhook_id,
        );

        $response = $httpClient->delete(
            $GLOBALS['yumit_merchants_api'] . '/webhook',
            [
                RequestOptions::QUERY => http_build_query($data),
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
