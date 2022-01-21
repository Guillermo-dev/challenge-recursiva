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

            // TODO:
            $_SESSION["cantPersonasRegistradas"]  = 50000;
            $_SESSION["promAniosRacing"] = utf8_encode($data[0][1]);
            $_SESSION["nombresRiver"] = ["Guille", "Guille1", "Guille2", "Guille3", "Guille4"];
            $_SESSION["tablaPersonas"] = [[utf8_encode($data[0][0]), utf8_encode($data[0][1]), utf8_encode($data[0][2])], [utf8_encode($data[1][0]), utf8_encode($data[1][1]), utf8_encode($data[1][2])]];
            $_SESSION["tablaEdades"] = [[500, "equipo", 22, 20, 24], [400, "equipo2", 22, 20, 24]];
        };
    }

    public static function getData(): void {
        if (isset($_SESSION["cantPersonasRegistradas"]))
            Response::getResponse()->appendData('cantPersonasRegistradas', $_SESSION["cantPersonasRegistradas"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');

        if (isset($_SESSION["promAniosRacing"]))
            Response::getResponse()->appendData('promAniosRacing', $_SESSION["promAniosRacing"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');

        if (isset($_SESSION["nombresRiver"]))
            Response::getResponse()->appendData('nombresRiver', $_SESSION["nombresRiver"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');

        if (isset($_SESSION["tablaPersonas"]))
            Response::getResponse()->appendData('tablaPersonas', $_SESSION["tablaPersonas"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');

        if (isset($_SESSION["tablaEdades"]))
            Response::getResponse()->appendData('tablaEdades', $_SESSION["tablaEdades"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');
    }
}
