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

    static function setPostRedirectSimple($url) {
        ?>

        <form name="WS1" id="WS1" action="<?= $url ?>" method="POST" onl>
            <input type="submit" id="submit_payment_gateway" style="visibility: hidden;"> 
        </form>

        <?php
    }

}
