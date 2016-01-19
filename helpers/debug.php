<?php

/*
 * @author = Cristian Tala Sánchez
 * @web = http://www.cristiantala.cl
 * 
 */

if (!function_exists("ctala_log_me")) {

    function ctala_log_me($message, $sufijo = "") {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
                error_log($sufijo . "\t-> " . $message);
            }
        }
    }

}

function ctala_log_me_screen($param) {
    echo '<pre>';

    if (is_array($param)) {
        print_r($param);
    } else {
        echo $param;
    }

    echo '</pre>';
}

function ctala_log_me_both($param) {
    ctala_log_me($param);
    ctala_log_me_screen($param);
}

?>
