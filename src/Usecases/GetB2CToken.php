<?php
function ymtp_getB2CToken(
    string $client_id,
    string $client_secret
) {

    try {
        $data = array(
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "grant_type" => "client_credentials",
            "scope" => $GLOBALS['b2c_scope'],
        );

        $args = array(
            'body' => $data,
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded'
            )
        );

        $response = wp_remote_post($GLOBALS['b2c_endpoint'], $args);

        if (is_wp_error($response)) {
            echo esc_html('Error en la solicitud: ' . $response->get_error_message());
        } else {
            $responseData = json_decode(wp_remote_retrieve_body($response), true);

            if (!isset($responseData['access_token'])) {
                echo esc_html('Error en la respuesta: ' . wp_remote_retrieve_body($response));
                return;
            }
            $accessToken = $responseData['access_token'];
            return $accessToken;
        }
    } catch (\Throwable $th) {
        echo esc_html($th->getMessage());
    }
}
