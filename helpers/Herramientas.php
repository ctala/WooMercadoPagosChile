<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CTalaTools;

/**
 * Description of Herramientas
 *
 * @author ctala
 */
class Herramientas {

    static function setPostRedirect($url) {
        ?>
        <html>
            <head>
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            </head> 
            <body style="">
                <form name="WS1" id="WS1" action="<?= $url ?>" method="POST" onl>
                    <input type="submit" id="submit_payment_gateway" style="visibility: hidden;"> 
                </form>
                <script>
                    $(document).ready(function () {
                        $("#WS1").submit();
                    });
                </script>
            </body>
        </html>

        <?php
    }

}
