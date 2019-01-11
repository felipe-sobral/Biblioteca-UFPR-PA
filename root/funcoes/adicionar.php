<?php
   session_start();

   require "../init.php";

   $dados = $_POST;

   if(!isset($dados["cod"])){
      echo "#false";
      exit;
   }

   switch($dados["cod"]){
      case sha1("e_usuarios"):
         $exec = new Construtor($dados["cod"]);
         break;

      case sha1("consulta_local"):
         $exec = new ConsultaLocal($dados["cod"]);
         break;

      default:
         echo "#false";
         exit;
   }
   
   $exec->adicionar($dados, 2);