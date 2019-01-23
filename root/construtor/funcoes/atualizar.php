<?php
   require_once "../../init.php";

   $att;

   $att = new ConsultaLocal(sha1("consulta_local"));

   if(isset($_POST['cod'])){

      switch($_POST['cod']){
         case 2:
            $att = new EstatisticaUsuarios(sha1("e_usuarios"));
            break;
      }

   }
   

   $att->atualizar(date("Y-m-d"));