<?php

/*
  Plugin Name: WooMercadoPagosChile
  Plugin URI:  https://github.com/ctala/WooMercadoPagosChile
  Description: Sistema de pagos para Chile usando Mercado Pagos.
  Version:     0.1
  Author:      Cristian Tala Sánchez
  Author URI:  http://www.cristiantala.cl
  License:     MIT
  License URI: http://opensource.org/licenses/MIT
  Domain Path: /languages
  Text Domain: ctala-text_domain
 */
include_once 'helpers/debug.php';
include_once 'vendor/autoload.php';


define("CTALA_MP_CLIENTID", "3456644172902315");
define("CTALA_MP_CLIENTSECRET", "eZHN1ladm87NneOypJqp91iZqesN82nt");



/*
 * Todo con respecto al pago.
 * La clase que inicializamos extiende de la que tiene todo el contenido.
 */

add_action('plugins_loaded', 'init_WCMPChile');

function init_WCMPChile() {
    if (!class_exists('WC_Payment_Gateway'))
        return;

    class WC_Gateway_Mercado_Pagos_Chile extends \WooMercadoPagosChile\WooPagosMP {

        function __construct() {
            parent::__construct();
            $this->notification_url =  str_replace('https:', 'http:', add_query_arg('wc-api', 'WC_Gateway_Mercado_Pagos_Chile', home_url('/')));
            add_action( 'woocommerce_api_wc_gateway_mercado_pagos_chile', array( $this, 'process_response' ) );
        }

    }

}

function add_your_gateway_class($methods) {
    $methods[] = 'WC_Gateway_Mercado_Pagos_Chile';
    return $methods;
}

add_filter('woocommerce_payment_gateways', 'add_your_gateway_class');
?>