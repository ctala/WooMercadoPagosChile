<?php

namespace WooMercadoPagosChile;

/**
 * Description of WooPagosMP
 *
 * @author ctala
 */
class WooPagosMP extends \WC_Payment_Gateway {

    function __construct() {
        $this->id = 'WooPagosMP';
        $this->has_fields = false;
        $this->method_title = 'WebPayPlus';

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');


        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * A continuacion todos los campos necesarios por la configuracion.
     */
    function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', 'woocommerce'),
                'type' => 'checkbox',
                'label' => "Habilitamos Mercado Pagos Chile",
                'default' => 'yes'
            ),
            'title' => array(
                'title' => __('Title', 'woocommerce'),
                'type' => 'text',
                'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
                'default' => "Mercado Pagos Chile",
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => __('Customer Message', 'woocommerce'),
                'type' => 'textarea',
                'default' => 'MP'
            ),
            'clientid' => array(
                'title' => __('Client ID', 'woocommerce'),
                'type' => 'text',
            ),
            'secretkey' => array(
                'title' => __('Secret Key', 'woocommerce'),
                'type' => 'text',
            ),
        );
    }

    function process_payment($order_id) {
        global $woocommerce;
        $order = new \WC_Order($order_id);
        $mp = new \MP($this->get_option('clientid'), $this->get_option('secretkey'));


        // Mark as on-hold (we're awaiting the cheque)
        $order->update_status('on-hold', __('Awaiting cheque payment', 'woocommerce'));

        // Reduce stock levels
        $order->reduce_order_stock();

        // Remove cart
        $woocommerce->cart->empty_cart();

        // Return thankyou redirect
        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url($order)
        );
    }

}
