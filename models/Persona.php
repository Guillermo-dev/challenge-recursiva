<?php

namespace models;

use JsonSerializable;

class Persona implements JsonSerializable {
    private $nombre;

    private $edad;

    private $equipo;

    private $estadoCivil;

    private $nivelEstudios;

    public function __construct(string $nombre = '', string $edad = '', string $equipo = '', string $estadoCivil = '', string $nivelEstudios = '') {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->equipo = $equipo;
        $this->estadoCivil = $estadoCivil;
        $this->nivelEstudios = $nivelEstudios;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getEdad(): string {
        return $this->edad;
    }

    public function getEquipo(): string {
        return $this->equipo;
    }

    public function getEstadoCivil(): string {
        return $this->estadoCivil;
    }

    public function getNivelEstudios(): string {
        return $this->nivelEstudios;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setEdad(string $edad): void {
        $this->edad = $edad;
    }

    public function setEquipo(string $equipo): void {
        $this->equipo = $equipo;
    }

    public function setEstadoCivil(string $estadoCivel): void {
        $this->estadoCivel = $estadoCivel;
    }

    public function setNivelEstudios(string $nivelEstudios): void {
        $this->nivelEstudios = $nivelEstudios;
    }

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }
}
