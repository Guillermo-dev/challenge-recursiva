<?php

namespace api;

use api\util\Response;
use models\Persona;
use Exception;

class Archivos {

    public static function procesarArchivo(): void {
        if (isset($_FILES["personasInfo"])) {
            // Lectura de archivo
            $file = fopen($_FILES["personasInfo"]["tmp_name"], "r");
            $personas = array();
            while (!feof($file)) {
                $data = fgetcsv($file, null, ';');
                if ($data) {
                    if (count($data) != 5)
                        throw new Exception('Archivo invalido');
                    else {
                        // Crear instancias de personas
                        $persona = new Persona(utf8_encode($data[0]), $data[1], utf8_encode($data[2]), $data[3], $data[4]);
                        $personas[] = $persona;
                    }
                }
            }
            fclose($file);

            // Cantidad de personas registradas
            $_SESSION["cantPersonasRegistradas"]  = count($personas);

            // Edad promedio de hinchas de racing
            $_SESSION["promEdadRacing"] = self::promedioEdadRacing($personas);

            // 5 nombre mas comunes de hinchas de river
            self::nombresRiver($personas);
            $_SESSION["nombresRiver"] = self::nombresRiver($personas);

            // 100 primeras personas casadas y con estudios universitarios, ordenadas de menor a mayor por edad
            $_SESSION["tablaPersonas"] = self::personasCasadasUniversitario($personas);

            // Lista de equipos ordenados por cantidad de socios con promedio edades
            $_SESSION["tablaEdades"] = self::listaEquipos($personas);
        };
    }

    public static function promedioEdadRacing(array $personas): int {
        $edades = array();
        foreach ($personas as $persona) {
            if (strtoupper($persona->getEquipo()) === "RACING") {
                $edades[] = $persona->getEdad();
            }
        }
        return array_sum($edades) / count($edades);
    }

    public static function nombresRiver(array $personas): array {
        $contNombres = array();
        foreach ($personas as $persona) {
            if (strtoupper($persona->getEquipo()) === "RIVER") {
                if (!isset($contNombres[$persona->getNombre()]))
                    $contNombres[$persona->getNombre()] = 1;
                else
                    $contNombres[$persona->getNombre()] += 1;
            }
        }
        arsort($contNombres);
        $contNombres = array_slice($contNombres, 0, 5);

        $nombres = array();
        while (current($contNombres)) {
            $nombres[] = key($contNombres);
            next($contNombres);
        }
        return $nombres;
    }

    public static function personasCasadasUniversitario(array $personas): array {
        $cienPrimeros = array();
        foreach ($personas as $persona) {
            if (strtoupper($persona->getEstadoCivil()) === "CASADO" && strtoupper($persona->getNivelEstudios()) === "UNIVERSITARIO") {
                $cienPrimeros[] = $persona;
            }
        }
        $cienPrimeros = array_slice($cienPrimeros, 0, 100);

        usort($cienPrimeros, function ($a, $b) {
            return $a->getEdad()> $b->getEdad();
        });

        return $cienPrimeros;
    }

    public static function listaEquipos(array $personas): array {
        $edadesEquipos = array();
        foreach ($personas as $persona) {
            $edadesEquipos[$persona->getEquipo()][] = $persona->getEdad();
        }
        uasort($edadesEquipos, function ($a, $b) {
            return count($a) < count($b);
        });

        $equipos = array();
        $i = 0;
        while (current($edadesEquipos)) {
            $equipos[$i]["cantSocios"] = count($edadesEquipos[key($edadesEquipos)]);
            $equipos[$i]["equipo"] = key($edadesEquipos);
            $equipos[$i]["promEdad"] = intval(array_sum($edadesEquipos[key($edadesEquipos)]) / count($edadesEquipos[key($edadesEquipos)]));
            $equipos[$i]["minEdad"] = min($edadesEquipos[key($edadesEquipos)]);
            $equipos[$i]["maxEdad"] = max($edadesEquipos[key($edadesEquipos)]);
            $i+=1;

            next($edadesEquipos);
        }
        return $equipos;
    }

    public static function getData(): void {
        if (isset($_SESSION["cantPersonasRegistradas"]))
            Response::getResponse()->appendData('cantPersonasRegistradas', $_SESSION["cantPersonasRegistradas"]);
        else
            throw new Exception('Problema interno, intentelo nuevamente');

        if (isset($_SESSION["promEdadRacing"]))
            Response::getResponse()->appendData('promEdadRacing', $_SESSION["promEdadRacing"]);
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
