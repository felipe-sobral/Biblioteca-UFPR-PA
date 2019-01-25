<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once QUERY;

   $usuario = $_POST['usuario'];
   $senha = sha1($_POST['senha']);

   $dados = usuario($usuario, $senha);

   if(!isset($dados[0])){
      retorna(false, "USUÁRIO OU SENHA INCORRETOS!");
      exit;
   }

   $dados = $dados[0];

   if(!isset($_SESSION)){
      session_start();
   }     

   $_SESSION['usr_id'] = $dados['id'];
   $_SESSION['usr_usuario'] = $dados['usuario'];
   $_SESSION['usr_senha'] = $dados['senha'];
   $_SESSION['usr_nome'] = $dados['nome'];
   $_SESSION['usr_email'] = $dados['email'];
   $_SESSION['usr_nivel'] = $dados['nivel'];
   $_SESSION['usr_ativo'] = $dados['ativo'];

   $query = new Query;

   $usuario = $query->valor("usuario", $_SESSION['usr_usuario']);
   $query->alterar("usuarios", ["sessao" => session_id()], "usuario = $usuario");

   if(!$query->executar()){
      retorna(false, "FALHA AO LOGAR");
      session_destroy();
      exit;
   }      

   retorna(true, "LOGIN REALIZADO!");
   exit;
