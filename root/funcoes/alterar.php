<?php
   session_start();

   require "../init.php";
   include "../templates/formulario.php";

   $dados = $_POST;

   $exec = new EstatisticaUsuarios( isset($dados["cod"]) ? $dados["cod"]:null );

   unset($dados["cod"]);
   
   
   $exec->formulario($exec->buscar($dados, 2));