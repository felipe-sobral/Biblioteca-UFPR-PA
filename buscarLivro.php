<?php
	session_start();

	include "cfg.php";

	$codigo = $_POST['barra'];

	$sql = mysqli_query($conectar, "SELECT * FROM livros WHERE barra = '{$codigo}' AND ativo = '1'") or die (mysql_error());
	$check = mysqli_num_rows($sql);

	$retorno = 0;
        
    if($check == 0){
    	
    	$retorno = 0;

    } else {
    	$dado = mysqli_fetch_array($sql);

    	$retorno = $dado['estante'];

    }

    echo $retorno;
    exit;
?>