<?php
if ( ! defined( 'ABSPATH' ) ) exit;
include_once plugin_dir_path(__FILE__) . '/../Models/Order.model.php';
include_once plugin_dir_path(__FILE__) . '/../Models/Product.model.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

function ymtp_productToItem(YMTP_Product $product)
{
    return array(
        "sku" => $product->sku,
        "description" => $product->description,
        "price" => $product->price,
        "quantity" => $product->quantity,
        "tax" => $product->total_tax,
        "discount" => 0,
        "thumbnailUrl" => "",
        "shipping" => 0,
    );
}

function ymtp_createOrder(
    YMTP_Order $order,
    string $accessToken
) {

    try {
        $httpClient = new Client();
        $data = array(
            "description" => "",
            "currency" => "CLP",
            "subtotal" => $order->subtotal,
            "shipping" => $order->shipping,
            "total" => $order->total,
            "tax" => $order->tax,
            "discount" => $order->discount,
            "discountDesc" => $order->discountDesc,
            "items" => array_map("ymtp_productToItem", $order->items),
        );
        $response = $httpClient->post(
            $GLOBALS['yumit_payments_api'] . '/orders',
            [
                RequestOptions::BODY => json_encode($data),
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]
        );

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    } catch (\Throwable $th) {
        throw $th;
    }
}
