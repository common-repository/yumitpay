<?php
if ( ! defined( 'ABSPATH' ) ) exit;
include_once plugin_dir_path(__FILE__) . '/../Usecases/PlaceOrder.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/GetB2CToken.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/GetOrderStatus.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/GetWebhookConfig.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/DeleteWebhookConfig.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/CreateWebhookConfig.php';
include_once plugin_dir_path(__FILE__) . '/../Usecases/CreateOrder.php';
include_once plugin_dir_path(__FILE__) . '/../Models/Order.model.php';

class YMTP_Gateway_YumitPay extends WC_Payment_Gateway
{
    public static $plugin_name = "YumitPay";
    private $client_id;
    private $client_secret;
    private YMTP_Order $yumit_order;
    public function __construct()
    {
        $this->id = $GLOBALS['gateway_id'];
        $this->order_button_text = "YumitPay - Paga con Cripto";
        $this->method_title = 'YumitPay';
        $this->method_description = 'Paga seguro con critomonedas usando YumitPay';
        $this->supports = ['products'];

        $this->init_form_fields();
        $this->init_settings();

        $this->enabled = $this->get_option('enabled');
        $this->client_id = $this->get_option('client_id');
        $this->client_secret = $this->get_option('client_secret');
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
        add_action('update_option', array(
            $this,
            'check_webhook_config'
        ), 10, 3);
    }

    public function check_webhook_config()
    {
        try {
            if (
                empty($this->client_id) or
                empty($this->client_secret) or
                empty($this->get_option('webhook_path'))
            ) {
                return false;
            }
            $access_token = ymtp_getB2CToken($this->client_id, $this->client_secret);

            if (
                empty($access_token)
                or $access_token == false
            ) {
                return false;
            }

            $webhook_config = ymtp_getWebhookConfig($access_token);

            if (
                $webhook_config == null
                or $webhook_config['url'] != $this->get_option('webhook_path')
            ) {

                if ($webhook_config != null) {
                    ymtp_deleteWebhookConfig($access_token, $webhook_config['webhookId']);
                }

                return ymtp_createWebhookConfig(
                    $access_token,
                    $this->get_option('webhook_path')
                );
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function update_order_status(
        string $order_id,
        string $trx_id,
        bool $is_cron_process = false

    ) {
        try {
            global $woocommerce;

            $order = new WC_Order($order_id);
            $access_token = ymtp_getB2CToken($this->client_id, $this->client_secret);
            $order_status = ymtp_getOrderStatus($trx_id, $access_token);

            if (
                $is_cron_process == false
            ) {
                $woocommerce->cart->empty_cart();
            }

            if (
                $order_status == "completed"
            ) {
                $order->update_status('completed');
                return true;
            } else if (
                $order_status == "pending"
            ) {
                $order->update_status(
                    'pending',
                );
                return false;
            }
        } catch (\Throwable $th) {
            echo esc_html($th->getMessage());
        }
    }

    public function webhook_order_status(
        string $order_id,
        string $status
    ) {
        try {
            global $woocommerce;
            $order = new WC_Order($order_id);

            if (
                $status == "completed" or $status == "startRampOff"
            ) {
                $order->update_status('processing');
                return true;
            } else if (
                $status == "pending"
            ) {
                $order->update_status(
                    'pending',
                );
                return false;
            } else if (
                $status == "canceled" or $status == "rampOffFailed" or $status == "rampOffExpired"
            ) {
                $order->update_status(
                    'failed',
                );
                return false;
            }
        } catch (\Throwable $th) {
            echo esc_html($th->getMessage());
        }
    }

    public function init_form_fields()
    {
        $fields = [
            'enabled' => [
                'title' => __('Activar/Desactivar'),
                'label' => __("Activar YumitPay Gateway"),
                'type' => 'checkbox',
                'description' => __("Activa/Desactiva YumitPay como metodo de pago"),
                'default' => 'no'
            ],
            'title' => [
                'title' => __('Titulo'),
                'type' => 'text',
                'description' => 'Esta opción controla el título que el usuario ve durante el pago.',
                'default' => 'YumitPay',
            ],
            'description' => [
                'title' => __('Descripcion'),
                'type' => 'textarea',
                'description' => 'Esta opción controla la descripción que el usuario ve durante el pago.',
                'default' => 'Paga de forma segura con tus criptomonedas en YumitPay.',
            ],
            'client_id' => [
                'title' => __('Client Id'),
                'type' => 'text',
                'description' => __('Este es el clientId que has generado dentro de YumitPay'),
                'default' => ''
            ],
            'client_secret' => [
                'title' => __('Client Secret'),
                'type' => 'password',
                'description' => __('Este es el secreto unico generado en YumitPay'),
                'default' => ''
            ],
            'webhook_path' => [
                'title' => __('Webhook URL'),
                'type' => 'text',
                'description' => __('A esta URL llamaremos para notificar el estado de los pagos.'),
                'default' => get_site_url() . '/wp-json/yumit-pay/v1/webhook',
            ],
            'logging' => [
                'title' => __('Activar Logs'),
                'label' => __('Activar/Desactivar'),
                'type' => 'checkbox',
                'description' => '',
                'default' => 'no'
            ],
        ];

        $this->form_fields = $fields;

        $section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : null;

        if (isset($_GET['section']) && !is_string($section)) {
            die('The provided data is not valid.');
        }

        if (strpos($_SERVER['REQUEST_URI'] ?? "", 'wc-settings') !== false && $section == $GLOBALS['gateway_id']) {
            echo '<div class="notice notice-warning is-dismissible">
                <p>Algunas criptomonedas requieren de mucho tiempo para confirmarse, por lo que te dejamos algunas indicaciones que ayudarán
                    a mejorar tu experiencia como comercio y a tus clientes como compradores
                </p>

                <ul>
                    <li>
                        <strong> ◦ Actualiza el tiempo minimo para mantener el stock de tus productos en 60 minutos (1 hora). </strong>
                    </li>
                    <li>
                        <strong> ◦ Algunos plugins son capaces de eliminar las ordenes, esto puede afectar nuestro funcionamiento, recuerda limitar estos plugins. </strong>
                    </li>
                </ul>
            </div>';
        }
    }

    public function process_payment($order_id)
    {
        try {
            if (empty($this->client_secret) or empty($this->client_id)) {
                wc_add_notice(__("Este metodo de pago no está disponible aún.", 'YumitPay'));
                return false;
            }

            if ($order_id != null) {
                global $woocommerce;
                $wc_order = new WC_Order($order_id);
                $yumit_order = ymtp_constructOrderByWC();
                $access_token = ymtp_getB2CToken($this->client_id, $this->client_secret);
                $response = ymtp_createOrder(
                    $yumit_order,
                    $access_token,
                );

                if ($response['statusCode'] == '403') {
                    wc_add_notice(__("Error procesando el pago, intentalo de nuevo más tarde.", 'YumitPay'));
                    return false;
                }

                $wc_order->update_meta_data('trx_id', $response['trxId']);
                $wc_order->save();

                $modal_params = array(
                    'trx_id' => $response['trxId'],
                    'woocommerce_url_redirect' => $this->get_return_url($wc_order),
                    'order_id' => $order_id,
                );

                return array(
                    'result' => 'success',
                    'redirect' => '#yumit-pay-modal/' . '?' . http_build_query($modal_params),
                );
            } else {
                wc_add_notice(__("Error procesando el pago, intentalo de nuevo más tarde."));
                return false;
            }
        } catch (\Throwable $th) {
            echo esc_html($th->getMessage());
        }
    }

    public function log($data, $prefix = '')
    {
        if ($this->logging) {
            $context = ['source' => $this->id];
            wc_get_logger()->debug($prefix . "\n" . print_r($data, 1), $context);
        }
    }
}
