<?php
   require_once "../../../init.php";

   $usuario = $_POST['usuario'];
   $senha = sha1($_POST['senha']);

   $dados = usuario($usuario, $senha);

   if(!isset($dados[0])){
      echo retorna(false, "USUÁRIO OU SENHA INCORRETOS!");
      exit;
   }

   $dados = $dados[0];

   if($dados){

      if(!isset($_SESSION)){
         session_start();
      }     

      $_SESSION['usr_id'] = $dados['id'];
      $_SESSION['usr_usuario'] = $dados['usuario'];
      $_SESSION['usr_senha'] = $dados['senha'];
      $_SESSION['usr_nome'] = $dados['nome'];
      $_SESSION['usr_email'] = $dados['email'];
      $_SESSION['usr_nivel'] = $dados['nivel'];
      $_SESSION['usr_stat'] = $dados['stat'];
      

      retorna(true, "LOGIN REALIZADO!");
      exit;
   }
   
   retorna(false, "NÃO FOI POSSÍVEL REALIZAR ESTA OPERAÇÃO!");
   exit;
