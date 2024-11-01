<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include_once plugin_dir_path(__FILE__) . '/../../Utils/Imports.util.php';

function ymtp_renderYumitPaymentButton()
{
    wp_localize_script(
        'yumit.bundle',
        'yumitConfigs',
        array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce($GLOBALS['nonce_id'])
        )
    );

    return "<button class='btn btn-yumit-payment alignleft' onclick='onPlaceOrder()'>
        <img src='{$GLOBALS['yumit_logo_url']}' alt='' srcset=''>
        <div class='labels-container'>
            <strong>Paga con Yumit</strong>
            <small>Paga con Cripto</small>
        </div>
    </button>
    ";
}
