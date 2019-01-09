<?php
   session_start();

   require "../init.php";
   include "../templates/formulario.php";

   $dados = $_POST;

   $exec = new EstatisticaUsuarios( isset($dados["cod"]) ? $dados["cod"]:null );

   $stat = $dados['stat'];

   unset($dados["cod"], $dados['stat']);

   if($stat == 'BUSCAR'){
      $exec->formulario($exec->buscar($dados, 2));
      exit;
   }

   if($stat== 'ALTERAR'){
      $exec->alterar($dados, 2);
      exit;
   }
   