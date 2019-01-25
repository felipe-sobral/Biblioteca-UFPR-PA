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

         case 6:
            return "USUÁRIO NÃO ESTÁ ATIVO";
            break;
      }
   }

   function retornoPadrao($status, $string){
      $status = json_encode($status);
      $string = htmlspecialchars($string, ENT_QUOTES);

      $json = ["status" => $status, "mensagem" => $string];

      echo json_encode($json);
   }

   function retornoHtml($stringHTML){
      echo "{\"status\": true, \"mensagem\": \"$stringHTML\"}";
   }

   function retornoErro($cod){
      echo "{\"status\": false, \"mensagem\": \""+retornaErro($cod)+"\"}";
   }

   function retorna($status, $string){
      $string = htmlspecialchars($string, ENT_QUOTES);

      $template = ["status" => boolval($status), "mensagem" => $string, "codigo" => "%1"];
      echo json_encode($template);
   }
