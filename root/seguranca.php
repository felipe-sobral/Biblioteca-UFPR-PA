<?php
   
   function acesso_restrito($nivel){
      if(isset($_SESSION, $_SESSION['usuario'], $_SESSION['senha'])){

         $query = new Query;

         return ($query->select(["usuarios"], ["*"])
                   ->parametro("usuario", "=", $_SESSION['usuario'])
                   ->and()->parametro("senha", "=", $_SESSION['senha'])
                   ->and()->parametro("nivel", ">=", $nivel)
                   ->construir()
                   ->array_assoc());

      } 
        
      return false;
   }

   