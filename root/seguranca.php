<?php
   
   function acesso_restrito($nivel){
      if(isset($_SESSION, $_SESSION['usuario'], $_SESSION['senha'])){

         $q = new Query;

         return ($q->select(["usuarios"], ["*"])
                   ->parametro("usuario", "=", $_SESSION['usuario'])
                   ->and()->parametro("senha", "=", $_SESSION['senha'])
                   ->and()->parametro("nivel", ">=", $nivel)
                   ->construir()
                   ->array_assoc());

      } else {
         return false;
      }
   }

   