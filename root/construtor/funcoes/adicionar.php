<?php
   require_once "../../init.php";

   $dados = $_POST;

   if(!isset($dados["cod"])){
      echo "{\"status\": false, \"mensagem\": \"#4#\"}";
      exit;
   }

   switch($dados["cod"]){
      case sha1("e_usuarios"):
         $exec = new Construtor($dados["cod"]);
         break;

      case sha1("consulta_local"):
         $exec = new ConsultaLocal($dados["cod"]);
         break;

      case sha1("consulta_local_INSERIR"):

         if(!isset($dados["codigo"]) || strlen(preg_replace('/[^[:digit:]_]/', '', $dados["codigo"])) != 8){
            echo "{\"status\": false, \"mensagem\": \"#4#\"}";
            exit;
         }

         $dados["codigo"] = preg_replace('/[^[:digit:]_]/', '', $dados["codigo"]);

         $exec = new Construtor(sha1("consulta_local"));
         break;

      default:
         echo "{\"status\": false, \"mensagem\": \"#4#\"}";
         exit;
   }
   
   $exec->adicionar($dados, 2);