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

   $manha = isset($_POST['manha']) ? $_POST['manha']:0;
   $tarde = isset($_POST['tarde']) ? $_POST['tarde']:0;
   $noite = isset($_POST['noite']) ? $_POST['noite']:0;
   $data = isset($_POST['data']) ? $_POST['data']:null;

   if($data == null){
      echo "#false";
      return;
   }

   $sql = new Query;

   if($sql->insert("e_usuarios", [$data, $manha, $tarde, $noite])->construir()){
      echo "#true";
   } else {
      echo "#false";
   };