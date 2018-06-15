<?php

	session_start();

	include "../cfg.php";
  include "../funcoesGerais.php";

	if(verificarNivel(5)){
		$data = $_POST['data'];
		$manha = $_POST['manha'];
		$tarde = $_POST['tarde'];
		$noite = $_POST['noite'];
		$mes = $_POST['mes'];
		$ano = $_POST['ano'];

		if($data == null || $manha == null || $tarde == null || $noite == null || $manha == null || $mes == null || $ano == null){
			echo 0;
			exit;
		}

		$sql = mysqli_query($conectar, "SELECT data FROM estatistica_usuarios WHERE data='{$data}'");

		if(verificarSql($sql)){
			echo 0;
			exit;
		} else {
			mysqli_query($conectar, "INSERT INTO estatistica_usuarios(manha, tarde, noite, n_mes, data, ano) VALUES ($manha, $tarde, $noite, $mes, '{$data}', $ano)");
			gravar_log("Adicionou estatística usuário [".$data."] * [#123#]");
			echo 1;
			exit;
		}

	} else {
		echo 0;
	}


?>
