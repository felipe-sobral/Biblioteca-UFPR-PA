<?php
   session_start();

   if(!isset($_SESSION) or !isset($_SESSION['usuario'])){
      echo "OPS... =(";
      return false;
   }

   require "../../init.php";

   if(!checkUsuario($_SESSION['usuario'], 2)){
      echo "OPS... =(";
      return false;
   }

   $mes = isset($_POST['mes']) ? $_POST['mes']:null;
   $ano = isset($_POST['ano']) ? $_POST['ano']:date('Y');

   if($mes == null){
      echo "#false";
      return false;
   }

   $sql = new Query;

   // ******** CONTINUAR AQUI ********

   if($sql->select(['e_usuarios'], ['*'])->parametro_direto('MONTH(data)', '=', $mes)->and()->parametro_direto('YEAR(data)', '=', $ano)->construir()){
      $test = $sql->array_assoc();

      foreach($test as $item){
         echo var_dump($test);
      }
      return;
   } else {
      echo "#false";
      return false;
   }
