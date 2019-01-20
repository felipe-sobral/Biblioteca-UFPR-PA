<?php
   require_once "init.php";
   require_once QUERY;

   /**
    * Funcao USUARIO
    *
    * Retorna informações do usuário passado caso contenha no banco de dados.
    *
    * @param  string $usuario
    * @param  string $senha
    *
    * @return bool|array
    */
   function usuario($usuario, $senha){
      $consulta = new Query;

      $vUsuario = $consulta->valor("usuario", "$usuario");
      $vSenha = $consulta->valor("senha", "$senha");

      $consulta->selecionar("usuarios", "*", "usuario = $vUsuario AND senha = $vSenha");

      if($consulta->executar()){
         return $consulta->assoc_array();
      }

      return false;
   }