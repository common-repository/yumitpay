<?php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

function ymtp_createWebhookConfig(
    string $access_token,
    string $webhook_url
) {
    try {
        $httpClient = new Client();
        $data = array(
            "name" => "Woocommerce Webhook",
            "url" => $webhook_url,
            "nonce" => wp_create_nonce('yumit_pay_webhook')
        );

        $response = $httpClient->post(
            $GLOBALS['yumit_merchants_api'] . '/webhook',
            [
                RequestOptions::BODY => json_encode($data),
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
