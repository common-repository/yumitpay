<?php
if ( ! defined( 'ABSPATH' ) ) exit;
wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . '/../../../assets/js/bootstrap.min.js');
wp_enqueue_script('yumit.bundle', plugin_dir_url(__FILE__) . '/../../../assets/js/index.js');
wp_enqueue_style('yumit.style', plugin_dir_url(__FILE__) . '/../../../assets/css/index.css');
