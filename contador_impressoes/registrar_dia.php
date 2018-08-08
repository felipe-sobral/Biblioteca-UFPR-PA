<?php

	session_start();

	include "../cfg.php";
  include "../funcoesGerais.php";

	if(verificarNivel(5)){
		$data = addslashes($_POST['data']);
		$total = (int)preg_replace('/[^0-9_]/', '',$_POST['total']);

		if($data == null || $total == null){
			echo 0;
			exit;
		}

		$sql = mysqli_query($conectar, "SELECT xdata FROM impressao WHERE xdata='{$data}'");

		if(verificarSql($sql)){
			echo 0;
			exit;
		} else {
			mysqli_query($conectar, "INSERT INTO impressao(total, xdata) VALUES ($total, '{$data}')");
			gravar_log("Adicionou estatística impressora [".$data."] * [#141#]");
			echo 1;
			exit;
		}

	} else {
		echo 0;
	}


?>
