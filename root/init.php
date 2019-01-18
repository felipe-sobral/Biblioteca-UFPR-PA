<?php
    define('DB_MAIN', 'Localhost');
    define('DB_MAIN_USR', 'root');
    define('DB_MAIN_PASS', 'root');
    define('DB_MAIN_NAME', 'biblioteca_0');

    ini_set('display_errors', true);
    error_reporting(E_ALL);

    require_once("construtor/funcoes/retorno.php");
    require_once("construtor/sql/Query.php");
    require_once("construtor/Construtor.php");
    require_once("construtor/ConsultaLocal.php");
    require_once("construtor/EstatísticaUsuarios.php");
    require_once("seguranca.php");
    