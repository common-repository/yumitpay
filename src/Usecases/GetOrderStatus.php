<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

include_once plugin_dir_path(__FILE__) . '/GetB2CToken.php';

function ymtp_getOrderStatus(
    string $trx_id,
    string $access_token
) {
    try {
        $httpClient = new Client();
        $data = array(
            "trxId" => $trx_id,
        );

        $response = $httpClient->get(
            $GLOBALS['yumit_payments_api'] . '/orders/get-status-by-trx-id',
            [
                RequestOptions::QUERY => http_build_query($data),
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                ],
            ]
        );


        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['status'];
    } catch (\Throwable $th) {
        echo esc_html($th->getMessage());
    }
}
