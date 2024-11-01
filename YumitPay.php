<?php
/**
 * Plugin URI: https://wordpress.org/plugins/yumitpay/
 * Plugin Name: YumitPay Paga con criptomonedas
 * Description: YumitPay es una pasarela de pagos que le permite a tus usuarios pagar con criptomonedas.
 * Version: 1.0.0
 * Author: Yumit
 * Author URI: https://www.yumitpay.com
 * License: GPLv2
 * Text Domain: YumitPay Paga con criptomonedas
 */

 if ( ! defined( 'ABSPATH' ) ) exit;
//  $GLOBALS['env_mode'] = "develop" | "local" | "production";
$GLOBALS['env_mode'] = "production";
$GLOBALS['nonce_id'] = 'yumit-nonce-production';
$GLOBALS['gateway_id'] = 'yumit_payment_gateway';

$GLOBALS['yumit_logo_url'] = plugins_url('assets/images/yumit-logo.png', __FILE__);

$GLOBALS['b2c_endpoint'] = 'https://login.microsoftonline.com/99faec66-4aaa-4f15-9f3e-b3dc04847ad2/oauth2/v2.0/token';
$GLOBALS['b2c_scope'] = 'https://yumitpay.onmicrosoft.com/payments-api-dev/.default';

if ($GLOBALS['env_mode'] == "local") {
    $GLOBALS['yumit_payments_api'] = 'http://localhost:3333/api';
    $GLOBALS['yumit_merchants_api'] = 'http://localhost:3336/api';
    $GLOBALS['yumit_payments_web'] = 'http://localhost:3000/';
} else if (
    $GLOBALS['env_mode'] == "develop"
) {
    $GLOBALS['yumit_payments_api'] = 'https://yumit-payments-api-dev.azurewebsites.net/api';
    $GLOBALS['yumit_merchants_api'] = 'https://yumit-merchants-api-dev.azurewebsites.net/api';
    $GLOBALS['yumit_payments_web'] = 'https://yumit-payments-cdn-dev-ehfna3hacdg0fec5.z01.azurefd.net/';
} else if (
    $GLOBALS['env_mode'] == "production"
) {
    $GLOBALS['yumit_payments_api'] = 'https://payments-api.yumitpay.com/api';
    $GLOBALS['yumit_merchants_api'] = 'https://merchants-api.yumitpay.com/api';
    $GLOBALS['yumit_payments_web'] = 'https://payments.yumitpay.com/';
}


require_once 'vendor/autoload.php';
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php');
include_once plugin_dir_path(__FILE__) . '/src/Usecases/PlaceOrder.php';



register_activation_hook(__FILE__, array('YumitPay', 'onActivatePlugin'));
register_deactivation_hook(__FILE__, array('YumitPay', 'onDeactivatePlugin'));
register_uninstall_hook(__FILE__, array('YumitPay', 'onUninstallPlugin'));

class YMTP_YumitPay
{
    private static $instance;
    public function __construct()
    {
        add_filter('woocommerce_payment_gateways', array($this, 'woocommercePaymentGateways'));
        add_action('wp_enqueue_scripts', array($this, 'frontendEnqueueScripts'), 5);
        add_action('wp_ajax_yumit_pay_webhook', array($this, 'update_order_status'));
        add_action('plugins_loaded', array($this, 'pluginsLoaded'));
        add_shortcode('yumit_payment_button', 'ymtp_renderYumitPaymentButton');
        add_action('wp_ajax_create_order', 'ymtp_createOrder');
        add_action('rest_api_init', function () {
            register_rest_route(
                'yumit-pay/v1',
                '/webhook',
                array(
                    'methods' => 'POST',
                    'callback' => array(
                        $this,
                        'on_call_webhook'
                    ),
                    'permission_callback' => '__return_true',
                )
            );
        });
    }

    public function on_call_webhook($request)
    {
        try {
            $this->pluginsLoaded();
            $decoded_body = json_decode($request->get_body(), true);
            $trx_id = $decoded_body['trxId'];
            $status = $decoded_body['status'];
            $gateway = new YMTP_Gateway_YumitPay();

            $order = wc_get_orders([
                'status' => 'pending',
                'limit' => -1,
                'payment_method' => $GLOBALS['gateway_id'],
                'meta_key' => 'trx_id',
                'meta_value' => $trx_id
            ]);

            if ($order == null) {
                return array(
                    'order_id' => null,
                    'status' => null,
                );
            }


            $gateway->webhook_order_status(
                $order[0]->get_id(),
                $status,
            );

            return array(
                'order_id' => $order[0]->get_id(),
                'status' => $status,
            );
        } catch (\Throwable $th) {
            echo  esc_html($th->getMessage());
        }
    }

    public function update_order_status()
    {
        check_ajax_referer($GLOBALS['nonce_id'], $_POST['nonce']);
        try {
            if (isset($_POST['order_id'])) {
                $order_id = sanitize_text_field($_POST['order_id']);
                if (!is_string($order_id)) {
                  die('Los datos proporcionados no son válidos.');
                }
              }

              if (isset($_POST['trx_id'])) {
                $trx_id = sanitize_text_field($_POST['trx_id']);

                if (!is_string($trx_id)) {
                  die('Los datos proporcionados no son válidos.');
                }
              }

            $gateway = new YMTP_Gateway_YumitPay();
            $gateway->__construct();
            $order_id = $_POST['order_id'];
            $trx_id = $_POST['trx_id'];
            $new_state = $gateway->update_order_status(
                $order_id,
                $trx_id
            );
            echo esc_html($new_state);
        } catch (\Throwable $th) {
            echo esc_html($th->getMessage());
        }
    }



    static function onActivatePlugin()
    {
        if (!function_exists('is_plugin_active')) {
            require_once(ABSPATH . '/wp-admin/includes/plugin.php');
        }

        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            wp_die('You must install woocommerce first');
        }
    }


    static function onDeactivatePlugin()
    {

    }

    static function onUninstallPlugin()
    {

    }


    public function pluginsLoaded()
    {
        require_once 'src/Woocommerce/PaymentGatewayInit.php';
    }

    public function frontendEnqueueScripts()
    {
        include_once plugin_dir_path(__FILE__) . '/src/Utils/Imports.util.php';
        if (is_checkout()) {
            wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js');
            wp_enqueue_script(
                'yumit-script',
                plugin_dir_url(__FILE__) . 'assets/js/index.js',
                ['jquery']
            );
            wp_localize_script(
                'yumit.bundle',
                'yumitConfigs',
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce($GLOBALS['nonce_id']),
                    'paymentsApiUrl' => $GLOBALS['yumit_payments_api'],
                    'paymentsWebUrl' => $GLOBALS['yumit_payments_web'],
                )
            );

        }
    }


    public function woocommercePaymentGateways($gateways)
    {
        $gateways[] = 'YMTP_Gateway_YumitPay';
        return $gateways;
    }


    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

YMTP_YumitPay::getInstance();
