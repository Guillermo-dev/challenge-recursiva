<?php

namespace controllers;

abstract class Direct {

    public static function index(): void {
        echo file_get_contents('src/pages/home/home.html');
    }

    public static function showData(): void {
        echo file_get_contents('src/pages/show-data/show-data.html');
    }

    public static function page404(): void {
        echo file_get_contents('src/pages/404/404.html');
    }
}
