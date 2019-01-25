<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once CONSTRUTOR;
   require_once ESTATISTICA_USUARIOS;
   require_once CONSULTA_LOCAL;

   if(!isset($_POST, $_POST["cod"])){
      retorna(false, "NEGADO!");
      exit;
   }
   
   $dados = $_POST;
   $tabela = $_POST["cod"];
   unset($dados["cod"]);

   $construtor = seleciona_construtor($tabela);
   
   if($construtor->adicionar($dados)){
      retorna(true, "DADOS ADICIONADOS COM SUCESSO!");
      exit;
   }

   retorna(false, "FALHA AO ADICIONAR");


   /*
   switch($dados["cod"]){
      case sha1("INSERIR_usuarios"):
         $exec = new Construtor(sha1("e_usuarios"));
         break;

      case sha1("CONTAR_usuario"):
         
         break;

      case sha1("CONTAR_consulta"):
         $exec = new ConsultaLocal(sha1("consulta_local"));
         break;

      case sha1("INSERIR_consultas"):

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
   }*/
   
   