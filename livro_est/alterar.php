<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(verificarNivel(3)){

    if(isset($_POST["pegarCodigos"])){

      $ano = $_POST["ano"];
      $dia = $_POST["dia"];
      $mes = $_POST["mes"];

      $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE ano='{$ano}' AND dia='{$dia}' AND mes='{$mes}'");

      if(verificarSql($sql)){
        $dado = mysqli_fetch_array($sql);

        echo "<textarea class='form-control' id='codigosAlterar' rows='10'>".$dado['codigos']."</textarea><script>var iden=".$dado['id']."</script>";
      } else {
        echo "0";
      }

    } elseif (isset($_POST["alterarCodigos"])) {
      $id = $_POST["iden"];

      $inserir = str_replace('
', '\r\n', $_POST["alterarCodigos"]);

      mysqli_query($conectar, "UPDATE consulta_local SET codigos='{$inserir}' WHERE id='{$id}'");

      echo "1";

    } else {
      echo "0";
    }

  } else {
    echo "0";
  }





?>
