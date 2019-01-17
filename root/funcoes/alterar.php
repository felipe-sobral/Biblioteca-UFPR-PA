<?php
   session_start();

   require "../init.php";
   include "../templates/formulario.php";
   include "../templates/tabela.php";

   $dados = $_POST;
   $cod = isset($dados["cod"]) ? $dados["cod"]:null;
   $exec;

   switch($cod){
      case sha1("e_usuarios"):
         $exec = new EstatisticaUsuarios($cod);
         break;

      case sha1("consulta_local"):
         $exec = new ConsultaLocal($cod);
         break;

      default:
         retornoErro(4);
         exit;
   }

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
   