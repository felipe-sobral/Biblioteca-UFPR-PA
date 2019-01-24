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
    define("FUNCOES", $link."/funcoes.php");
    define("SEGURANCA", $link."/seguranca.php");

        // CONSTRUTOR
        define("CONSTRUTOR", $link."/construtor/Construtor.php");
        define("CONSULTA_LOCAL", $link."/construtor/ConsultaLocal.php");
        define("ESTATISTICA_USUARIOS", $link."/construtor/EstatisticaUsuarios.php");

            // CONSTRUTOR/FUNCOES
            define("RETORNO", $link."/construtor/funcoes/retorno.php");

                // CONSTRUTOR/FUNCOES/SESSAO
                define("AUTENTICACAO", $link."/construtor/funcoes/sessao/autenticacao.php");

            // CONSTRUTOR/SQL
            define("QUERY", $link."/construtor/sql/Query.php");

            // CONSTRUTOR/TEMPLATES
            define("FORMULARIO", $link."/construtor/templates/Formulario.php");
            define("MENU", $link."/construtor/templates/Menu.php");
            define("TABELA", $link."/construtor/templates/Tabela.php");

    /**
     * @ EXTRAS
     */

    ini_set("display_errors", true);
    error_reporting(E_ALL);

    require_once(RETORNO);
    require_once(FUNCOES);
    