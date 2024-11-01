<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include_once plugin_dir_path(__FILE__) . '/../Models/Order.model.php';
include_once plugin_dir_path(__FILE__) . '/../Models/Product.model.php';

function ymtp_getProductsOnCart()
{
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $products = array();

    foreach ($items as $_ => $values) {
        $_product = wc_get_product($values['data']->get_id());
        $products[] = new YMTP_Product(
            wc_get_product_id_by_sku($_product->get_sku()),
            $_product->get_description(),
            $_product->get_price(),
            $values['quantity'],
            $values['line_tax'],
            $_product->get_name(),
        );
    }

    return $products;
}

/**
 * @return YMTP_Order
 */
function ymtp_constructOrderByWC()
{
    try {
        global $woocommerce;

        $order = new YMTP_Order();
        $products = ymtp_getProductsOnCart();
        $order->setTotal($woocommerce->cart->get_total('edit'));
        $order->setItems($products);

        return $order;
    } catch (\Throwable $th) {
        echo esc_html($th->getMessage());
    }
}
