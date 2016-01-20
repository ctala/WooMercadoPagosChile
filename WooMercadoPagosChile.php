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


/*
 * Todo lo relacionado con los template para la página de éxito
 */

/**
 * 
 * @return type : ruta absoluta del plugin
 */
function ctala_woo_mercado_pago_path() {

    // gets the absolute path to this plugin directory

    return untrailingslashit(plugin_dir_path(__FILE__));
}

/*
 * Agregamos nuestro directorio a la lista de directorios donde se encontraran los temas    
 */
add_filter('woocommerce_locate_template', 'ctala_woo_mercado_pago_template', 10, 3);

function ctala_woo_mercado_pago_template($template, $template_name, $template_path) {

    global $woocommerce;



    $_template = $template;

    if (!$template_path)
        $template_path = $woocommerce->template_url;

    $plugin_path = ctala_woo_mercado_pago_path() . '/woocommerce/';



    // Look within passed path within the theme - this is priority

    $template = locate_template(
            array(
                $template_path . $template_name,
                $template_name
            )
    );



    // Modification: Get the template from this plugin, if it exists

    if (!$template && file_exists($plugin_path . $template_name))
        $template = $plugin_path . $template_name;



    // Use default template

    if (!$template)
        $template = $_template;



    // Return what we found

    return $template;
}

/*
 * Agregamos el CSS que sera necesario para los mensajes en la pagina de thankyou
 */

function ctala_theme_name_scripts() {
    $bootstrapMin = "//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js";
    wp_enqueue_style('ctala_bootstrap', $bootstrapMin);
     
}

add_action('wp_enqueue_scripts', 'ctala_theme_name_scripts');

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
            $this->notification_url = str_replace('https:', 'http:', add_query_arg('wc-api', 'WC_Gateway_Mercado_Pagos_Chile', home_url('/')));
            add_action('woocommerce_api_wc_gateway_mercado_pagos_chile', array($this, 'process_response'));
        }

    }

}

function add_your_gateway_class($methods) {
    $methods[] = 'WC_Gateway_Mercado_Pagos_Chile';
    return $methods;
}

add_filter('woocommerce_payment_gateways', 'add_your_gateway_class');
?>