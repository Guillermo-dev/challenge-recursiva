<?php

namespace api;

use api\util\Response;
use models\Persona;
use Exception;

abstract class Archivos {

    public static function procesarArchivo(): void {
        if (isset($_FILES["personasInfo"])) {

            // Lectura de archivo
            $file = fopen($_FILES["personasInfo"]["tmp_name"], "r");
            $data = array();
            while (!feof($file))
                $data[] = fgetcsv($file, null, ';');
            fclose($file);

            if (count($data[0]) != 5)
                throw new Exception('Archivo invalido');

            // Instanciar personas y almacenarlas en un array
            $personas = array();
            foreach ($data as $personaData) {
                if ($personaData != false) {
                    $persona = new Persona($personaData[0], $personaData[1], $personaData[2], $personaData[3], $personaData[4]);
                    $personas[] = $persona;
                }
            }

            $_SESSION["cantPersonasRegistradas"]  = utf8_encode($data[0][1]);
            $_SESSION["promAniosRacing"] = 5000;
            $_SESSION["nombresRiver"] = ["Guille","Guille1","Guille2","Guille3","Guille4"];
        };
    }

    public static function getData(): void {
        Response::getResponse()->appendData('cantPersonasRegistradas', $_SESSION["cantPersonasRegistradas"]);
        Response::getResponse()->appendData('promAniosRacing', $_SESSION["promAniosRacing"]);
        Response::getResponse()->appendData('nombresRiver', $_SESSION["nombresRiver"]);
        //Response::getResponse()->appendData('tablaPersonas', $_SESSION["tablaPersonas"]);
        //Response::getResponse()->appendData('tablaEdades', $_SESSION["tablaEdades"]);
    }
}
