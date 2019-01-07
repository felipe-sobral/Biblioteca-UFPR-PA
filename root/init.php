<?php
    define('DB_MAIN', 'Localhost');
    define('DB_MAIN_USR', 'root');
    define('DB_MAIN_PASS', 'root');
    define('DB_MAIN_NAME', 'biblioteca_0');

    ini_set('display_errors', true);
    error_reporting(E_ALL);

    require("querys/query.php");
    require("seguranca.php");
    require("construtor.php");