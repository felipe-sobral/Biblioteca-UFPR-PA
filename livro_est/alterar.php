<?php

  include "../cfg.php";
  include "../funcoesGerais.php";

  //if(verificarNivel(3)){ // ARRUMAR AQUI - PERMISSÕES ## ARRUMAR HTML

    if(isset($_POST["pegarCodigos"])){

      $ano = $_POST["ano"];
      $dia = $_POST["dia"];
      $mes = $_POST["mes"];

      $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE ano='{$ano}' AND dia='{$dia}' AND mes='{$mes}'");

      if(verificarSql($sql)){
        $dado = mysqli_fetch_array($sql);

        echo "<textarea class='form-control' id='codigosAlterar' rows='10'>".$dado['codigos']."</textarea><script>var iden=".$dado['id']."</script>";
      } else {
        echo 0;
      }

    } elseif (isset($_POST["alterarCodigos"])) {
      $new_cod = nl2br($_POST["alterarCodigos"]);
      $id = $_POST["iden"];

      //<br />
      //str_replace('&', 'e', $string)

      $inserir = str_replace('\n', '\r\n', $_POST["alterarCodigos"]);

      mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$inserir}' WHERE id='{$id}'");

      /*
      $dados = explode("<br />", $new_cod);

      $i = 0;

      while(isset($dados[$i])){
        $inserir = $dados[$i];

        if($i == 0){
          mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$inserir}' WHERE id='{$id}'");
        } else {
          $inserir = "\r\n".$inserir;
          mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$inserir}' WHERE id='{$id}'");
        }

        $i++;
      }*/

    } else {
      echo "0 ERRO 1";
    }

  /*} else {
    echo "0 ERRO 2";
  }*/





?>
