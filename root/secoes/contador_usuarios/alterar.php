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

   //$stat -> BUSCAR - EDITAR - EXCLUIR
   if(isset($_POST['stat'])){

      switch($_POST['stat']){
         case 'BUSCAR':
            buscar();
            break;
         
         case 'EDITAR':
            editar();
            break;

         case 'EXCLUIR':
            excluir();
            break;
      }

   } else {
      echo "#false";
      return false;
   }


   function buscar(){
      if(!isset($_POST['dia'], $_POST['mes'], $_POST['ano'])){
         echo "#false";
         exit;
      }

      $query = new Query;
      if($sql->select(['e_usuarios'], ['*'])
             ->parametro('DAY(data)', '=', $_POST['dia'])
             ->and()
             ->parametro('MONTH(data)', '=', $_POST['mes'])
             ->and()
             ->parametro('YEAR(data)', '=', $_POST['ano'])
             ->construir()){
         
         $dia = $sql->array_assoc();

         if($dia == null){
            echo "#false";
            exit;
         }      

         // CONTINUAR DAQUI -----------------

      }
   }