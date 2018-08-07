<?php

	session_start();

	include "../cfg.php";
  include "../funcoesGerais.php";

	if(verificarNivel(5)){
		$data = preg_replace('/[^0-9\-_]/', '',$_POST['data']);
		$total = preg_replace('/[^0-9_]/', '',$_POST['total']);
		$mes = preg_replace('/[^0-9_]/', '',$_POST['mes']);
		$ano = preg_replace('/[^0-9_]/', '',$_POST['ano']);

		if($data == null || $total == null || $mes == null || $ano == null){
			echo 0;
			exit;
		}

		$sql = mysqli_query($conectar, "SELECT data FROM estatistica_impressao WHERE data='{$data}'");

		if(verificarSql($sql)){
			echo 0;
			exit;
		} else {
			mysqli_query($conectar, "INSERT INTO estatistica_impressao(total, n_mes, data, ano) VALUES ($manha, $tarde, $noite, $mes, '{$data}', $ano)");
			gravar_log("Adicionou estatística usuário [".$data."] * [#123#]");
			echo 1;
			exit;
		}

	} else {
		echo 0;
	}


?>
