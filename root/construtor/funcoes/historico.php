<?php
   require_once "../../init.php";
   require_once "../templates/classes/Tabela.php";

   $dados = $_POST;

   if(!isset($dados["cod"])){
      echo "#false";
      exit;
   }

   switch($dados["cod"]){
      case sha1("e_usuarios"):
         $exec = new EstatisticaUsuarios($dados["cod"]);
         break;

      case sha1("consulta_local"):
         $exec = new ConsultaLocal($dados["cod"]);
         break;

      default:
         echo "{\"status\": false, \"mensagem\": \"#4#\"}";
         exit;
   }

   unset($dados["cod"]);
   
   $exec->historico($dados, 2);
   $exec->tabela($exec->get_dataTabela());