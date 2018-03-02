<?php
	session_start();

	include "cfg.php";

	$codigo = $_POST['barra'];
	$item = $_POST['item'];

	$sql = mysqli_query($conectar, "SELECT * FROM livros WHERE barra='{$codigo}' OR codigo='{$codigo}' AND ativo = '1'") or die (mysql_error());
	$check = mysqli_num_rows($sql);

	$retorno = 0;

    if($check == 0){

    	$retorno = 0;

    } else {
    	$dado = mysqli_fetch_array($sql);

			switch ($item) {
				case 0:
					$retorno = $dado['estante'];
					break;

				case 1:
					$retorno = $dado['nome'];
					break;

				case 2:
					$retorno = $dado['link'];
					break;

				case 3:
					$retorno = $dado['barra'];
					break;

				case 4:
					$retorno = $dado['codigo'];
					break;

			}


    }

    echo $retorno;
    exit;
?>
