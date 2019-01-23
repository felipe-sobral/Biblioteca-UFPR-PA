<?php
    define("DB_MAIN", "Localhost");
    define("DB_MAIN_USR", "root");
    define("DB_MAIN_PASS", "root");
    define("DB_MAIN_NAME", "biblioteca_0");

    define("HOST", "localhost");

    $link = realpath(dirname(__FILE__));

    define("RETORNO", $link."/construtor/funcoes/retorno.php");
    define("CONSTRUTOR", $link."/construtor/Construtor.php");
    define("FUNCOES", $link."/funcoes.php");
    define("QUERY", $link."/construtor/sql/Query.php");
    define("CONSULTA_LOCAL", $link."/construtor/ConsultaLocal.php");
    define("ESTATISTICA_USUARIOS", $link."/construtor/EstatisticaUsuarios.php");
    define("FORMULARIO", $link."/construtor/templates/Formulario.php");
    define("MENU", $link."/construtor/templates/Menu.php");
    define("TABELA", $link."/construtor/templates/Tabela.php");
    define("AUTENTICACAO", $link."/construtor/funcoes/sessao/autenticacao.php");

    define("SEGURANCA", $link."/seguranca.php");

    ini_set("display_errors", true);
    error_reporting(E_ALL);

    require_once(RETORNO);
    require_once(FUNCOES);
    // require_once(CONSTRUTOR);
    // require_once(CONSULTA_LOCAL);
    // require_once(ESTATISTICA_USUARIOS);
    // require_once(SEGURANCA);
    