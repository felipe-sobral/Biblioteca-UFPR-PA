<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once TABELA;
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

   if(!$construtor){
      retorna(false, "CÓDIGO INVÁLIDO");
   }
   
   if($construtor->historico($dados)){
      $construtor->tabela($construtor->get_dataTabela());
      exit;
   }

   retorna(false, "FALHA AO CONSULTAR");
   exit;
   