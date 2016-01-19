<?php

namespace WooMercadoPagosChile;

/**
 * Description of WooPagosMP
 *
 * @author ctala
 */
class WooPagosMP extends \WC_Payment_Gateway {

    var $notification_url;

    function __construct() {
        $this->id = 'WooPagosMP';
        $this->has_fields = false;
        $this->method_title = 'Mercado Pago Chile';

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->notification_url = str_replace('https:', 'http:', add_query_arg('wc-api', 'WooPagosMP', home_url('/')));

        add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));
        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

        add_action('woocommerce_api_wc_gateway_paypal', array($this, 'check_ipn_response'));
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
            'desarrollo' => array(
                'title' => __('Enable/Disable', 'woocommerce'),
                'type' => 'checkbox',
                'label' => "Utilizaremos un Sandbox ?",
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

    /**
     * 
     * @global type $woocommerce
     * @param type $order_id
     * @return type
     * 
     * Esta funcion se ejecuta junto luego de seleccionar el metodo de pago. 
     * 
     */
    function process_payment($order_id) {
        global $woocommerce;
        $order = new \WC_Order($order_id);

        return array(
            'result' => 'success',
            'redirect' => $order->get_checkout_payment_url(true)
        );
    }

    /**
     * 
     * @param type $order
     * Esta funcion se ejecuta luego de seleccionar el metodo de pago y despues de la
     * funcion process payment.
     */
    function receipt_page($order_id) {
        global $woocommerce;
        $order = new \WC_Order($order_id);
        $preference_data = array();
        $mp = new \MP($this->get_option('clientid'), $this->get_option('secretkey'));

        echo '<p>' . __('¡Gracias! - Tu orden ahora está pendiente de pago.') . '</p>';


        $orderItems = $order->get_items();


        $items = array();
        foreach ($orderItems as $orderItem) {
            $id = $orderItem["item_meta"]["_product_id"][0];
            $qty = intval($orderItem["item_meta"]["_qty"][0]);
            $product = new \WC_Product($id);
            $price = (float) $product->price;

            $items[] = array(
                "title" => $product->get_title(),
                "quantity" => $qty,
                "currency_id" => "CLP",
                "unit_price" => $price
            );

            /*
             * Liberamos algo de memoria para wordpress.
             */
            unset($price);
            unset($product);
            unset($id);
            unset($qty);
        }
        ctala_log_me_both($items);



        /*
         * Agregamos las URL Correspondientes a las respuestas.
         */
        $successUrl = $this->get_return_url($order);
        $failureUrl = $this->get_return_url($order);
        $pendingUrl = $this->get_return_url($order);

        $back_urls = array(
            'success' => $successUrl,
            'pending' => $pendingUrl,
            'failure' => $failureUrl
        );

        /**
         * Sobre los metodos de pago
         */
        $excluded_payment_methods = array(
            "id" => "master"
        );
        $excluded_payment_types = array(
            "id" => "ticket"
        );

        $installments = 12;
        $payment_methods = array(
//            'excluded_payment_methods' => $excluded_payment_methods,
//            'excluded_payment_types' => $excluded_payment_types,
            'installments' => $installments
        );

        /*
         * Informacion adicional
         */

        $additional_info = array(
            'order_id' => $order_id,
        );

        $preference_data["additional_info"] = $additional_info;
        $preference_data["items"] = $items;
        $preference_data["back_urls"] = $back_urls;
        $preference_data["notification_url"] = $this->notification_url;
        $preference_data["auto_return"] = "approved";
        $preference_data["payment_methods"] = $payment_methods;


        $preference = $mp->create_preference($preference_data);

        ctala_log_me_both($preference);


        /**
         * La Url de redireccion dependera de si estamos en modo desarrollo.
         */
        $modoDesarrollo = $this->get_option('desarrollo');

        ctala_log_me($modoDesarrollo, "[MODO DESARROLLO]");

        if ($modoDesarrollo == "yes") {
            $url = $preference['response']['sandbox_init_point'];
        } else {
            $url = $preference['response']['init_point'];
        }

        \CTalaTools\Herramientas::setPostRedirect($url);
    }

    /*
     * Esta funcion procesara la llamada de MP para corroborar el pago exitoso.
     */

    function process_response() {
        if (isset($_REQUEST['id']) && isset($_REQUEST['topic'])) {
            ctala_log_me($_REQUEST, "[RESPONSE]");
            $mp = new \MP($this->get_option('clientid'), $this->get_option('secretkey'));
            $payment_info = $mp->get_payment_info($_GET["id"]);
            ctala_log_me($payment_info);
            if ($payment_info["status"] == 200) {
                print_r($payment_info["response"]);
            }
        }
    }

}
