<?php
    /**
     * @ BANCO_DE_DADOS
     */

    define("DB_MAIN", "Localhost");
    define("DB_MAIN_USR", "root");
    define("DB_MAIN_PASS", "root");
    define("DB_MAIN_NAME", "biblioteca_0");

    define("HOST", "localhost");

    $link = realpath(dirname(__FILE__));

    /**
     * @ IMPORTAÇÕES
     */

    // ROOT

        // CONSTRUTOR
        define("CONSTRUTOR", $link."/construtor/Construtor.php");
        define("CONSULTA_LOCAL", $link."/construtor/ConsultaLocal.php");
        define("ESTATISTICA_USUARIOS", $link."/construtor/EstatisticaUsuarios.php");

        // FUNCOES
        define("RETORNO", $link."/funcoes/retorno.php");
        define("AUTENTICACAO", $link."/funcoes/autenticacao.php");
        define("HTML", $link."/funcoes/tratar_html.php");
        define("ADICIONAL", $link."/funcoes/adicional.php");

        // SQL
        define("QUERY", $link."/sql/Query.php");

        // TEMPLATES
        define("FORMULARIO", $link."/templates/Formulario.php");
        define("MENU", $link."/templates/Menu.php");
        define("TABELA", $link."/templates/Tabela.php");

    /**
     * @ EXTRAS
     */

    ini_set("display_errors", true);
    error_reporting(E_ALL);

    require_once(RETORNO);
    require_once(AUTENTICACAO);
    