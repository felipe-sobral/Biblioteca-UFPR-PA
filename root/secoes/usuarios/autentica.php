<?php
	require "../../init.php";
	session_start();

   if(isset($_SESSION['usuario'])){

		$usuario = $_SESSION['usuario'];
      $senha = $_SESSION['senha'];

		if(autenticarUsuario($usuario, $senha) != "#false"){
			echo "#true";
			return true;
		}
		
	} else {
		echo "#false";
		return;
	}