<?php
   session_start();

   require "../init.php";
   include "../templates/tabela.php";

   $dados = $_POST;

   $exec = new EstatisticaUsuarios( isset($dados["cod"]) ? $dados["cod"]:null );

   unset($dados["cod"]);
   
   $exec->historico($dados, 2);
   $exec->tabela($exec->get_dataTabela());