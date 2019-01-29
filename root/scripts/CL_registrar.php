<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once QUERY;
   require_once CONSTRUTOR;
   require_once CONSULTA_LOCAL;  

   if(!isset($_POST, $_POST["codigo"])){
      retorna(false, "VARIÁVEIS INCOMPATÍVEIS");
   }

   echo $_POST["codigo"];


   $codigo = preg_replace('/[^[:digit:]_]/', '', $_POST["codigo"]);

   echo "<br><br>".strlen($codigo);

   if(strlen($codigo) !== 8){
      retorna(false, "CÓDIGO INSERIDO É INVÁLIDO");
   }

   $query = new Query;


   $query->inserir("livros", ["codigo" => $codigo, "estante" => null, "titulo" => null, "link" => null]);
   $query->executar();


   $query->inserir("consulta_local", ["id" => null, "LIVROS_codigo" => $codigo, "data" => date("Y-m-d")]);

   if($query->executar()){
      retorna(true, "CÓDIGO INSERIDO");
   }

   retorna(false, "FALHOU AO INSERIR");

