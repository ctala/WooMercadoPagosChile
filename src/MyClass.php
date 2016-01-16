<?php

namespace MyVendor;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class MyClass {

    public static function postInstall() {
        $projectname = basename(realpath("."));
        echo "Proyecto $projectname creado exitosamente\n";

        // Acá va el contenido a reemplazar, 
        // en este caso {{ projectname }}
        $replaces = [
            "{{ projectname }}" => $projectname
        ];


        foreach (glob("skel/templates/{,.}*-dist", GLOB_BRACE) as $distfile) {

            $target = substr($distfile, 15, -5);

            // Se copia el archivo,
            // Se sobreescriben los archivos que ya existían..
            echo "creating clean file ($target) from dist ($distfile)...\n";
            copy($distfile, $target);

            // Then we apply our replaces for within those templates.
            echo "applying variables to $target...\n";
            MyClass::applyValues($target, $replaces);
        }

        MyClass::renamePlugin($projectname);
        echo "\033[0;32mdist script done...\n";
    }

    public static function test() {
        echo "HOLA\n";
    }

    public static function renamePlugin($name) {
        \rename("Plugin.php", $name . ".php");
    }

    /**
     * A method that will read a file, run a strtr to replace placeholders with
     * values from our replace array and write it back to the file.
     *
     * @param string $target the filename of the target
     * @param array $replaces the replaces to be applied to this target
     */
    public static function applyValues($target, $replaces) {
        file_put_contents(
                $target, strtr(
                        file_get_contents($target), $replaces
                )
        );
    }

}
