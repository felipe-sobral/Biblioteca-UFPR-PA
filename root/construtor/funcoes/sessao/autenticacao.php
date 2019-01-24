<?php
   /**
    * CORRIGIR
    */
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";

   /**
    * 
    * $_SESSION['usr_id'] = $dados['id'];
    * $_SESSION['usr_usuario'] = $dados['usuario'];
    * $_SESSION['usr_senha'] = $dados['senha'];
    * $_SESSION['usr_nome'] = $dados['nome'];
    * $_SESSION['usr_email'] = $dados['email'];
    * $_SESSION['usr_nivel'] = $dados['nivel'];
    * $_SESSION['usr_stat'] = $dados['stat'];
    */

   if(!isset($_SESSION)){
      session_start();
   }

   function verificarSessao(){
      if(isset($_SESSION["usr_id"], $_SESSION["usr_usuario"], $_SESSION["usr_senha"], $_SESSION["usr_nome"], $_SESSION["usr_email"], $_SESSION["usr_nivel"], $_SESSION["usr_stat"])){

         $dados = usuario($_SESSION["usr_usuario"], $_SESSION["usr_senha"]);
   
         if(!isset($dados[0])){
            return false;
         }
         
         return true;
      }

      return false;
   }
   
   /**
    * Retorna TRUE caso o usuário logado ter nível superior ao nivel informado
    *
    * @param int $nivel
    * @return bool
    */
   function restrito($nivel){
      if(verificarSessao()){
         if($_SESSION["usr_nivel"] >= $nivel){
            return true;
         }
      }

      return false;
   }

   