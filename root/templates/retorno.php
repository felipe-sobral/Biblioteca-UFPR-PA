<?php

   // CONSTRUÇÃO 

   function retornaErro($codigo){
      switch($codigo){
         case 1:
            return "TABELA NÃO SELECIONADA";
            break;

         case 2:
            return "TABELA INVÁLIDA";
            break;

         case 3:
            return "ERRO AO INSERIR";
            break;

         case 4:
            return "VALORES INCOMPATÍVEIS";
            break;

         case 5:
            return "ERRO AO SELECIONAR OU NÃO EXISTE";
            break;
      }
   }

   function retornoPadrao($status, $string){
      $status = bool($status);
      $string = htmlspecialchars($string, ENT_QUOTES);

      echo "{\"status\": $status, \"mensagem\": \"$string\"}";
   }

   function retornoHtml($stringHTML){
      echo "{\"status\": true, \"mensagem\": \"$stringHTML\"}";
   }

   function retornoErro($cod){
      echo "{\"status\": false, \"mensagem\": \""+retornaErro($cod)+"\"}";
   }
