<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once TABELA;
   require_once FORMULARIO;
   require_once CONSTRUTOR;
   require_once ESTATISTICA_USUARIOS;
   require_once CONSULTA_LOCAL;

   if(!isset($_POST, $_POST["cod"], $_POST["stat"])){
      retorna(false, "NEGADO!");
      exit;
   }
   
   $dados = $_POST;
   $tabela = $_POST["cod"];
   $status = $_POST["stat"];
   unset($dados["cod"], $dados["stat"]);

   $construtor = seleciona_construtor($tabela);

   if(!$construtor){
      retorna(false, "CÓDIGO INVÁLIDO");
   }

   switch($status){
      case "BUSCAR":
         $informacoes = $construtor->buscar($dados);

         if(!$informacoes){
            retorna(false, "ERRO AO CONSULTAR");
         }

         // @ saida
         $construtor->formulario_alterar($informacoes);
         
         exit;

      case "ALTERAR":

         if($construtor->alterar($dados)){
            retorna(true, "INFORMAÇÕES ALTERADAS!");
            exit;
         }

         break;

      default:
         retorna(false, "OPERAÇÃO INVÁLIDA");
         exit;
   }

   retorna(false, "TERMINOU INCORRETAMENTE");
   