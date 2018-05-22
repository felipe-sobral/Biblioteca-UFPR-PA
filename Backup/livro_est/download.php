<?php
  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  if(!verificarLogin(3)){
    echo 0;
    exit;
  }

  function gravar($codigos, $nomeArquivo, $nomePasta){
    $endereco = $nomePasta."/".$nomeArquivo.".txt";

    $abrir = fopen($endereco, "w");

    fwrite($abrir, $codigos);

    fclose($abrir);

    return $endereco;
  }

  function baixarArquivo($enderecoArquivo){
    if(file_exists($enderecoArquivo)){
      echo $enderecoArquivo;
    }
  }

  $mes = $_POST['mes'];
  $ano = $_POST['ano'];

  $sql = mysqli_query($conectar, "SELECT * FROM consulta_local WHERE mes='{$mes}' AND ano='{$ano}'");

  if(verificarSql($sql)){
    if($mes <= 9){
      $mes = "0".$mes;
    }

    $nomePasta = "./downloads/".$mes."-".$ano;

    if(!file_exists($nomePasta)){
      mkdir($nomePasta, 0755, true);
    }

    $zip = new ZipArchive();
    $zip->open($nomePasta."/consulta_local.zip", ZIPARCHIVE::CREATE||ZIPARCHIVE::OVERWRITE);

    while($dado = mysqli_fetch_array($sql)){

      if($dado['dia'] <= 9){
        $dia = "0".$dado['dia'];
      } else {
        $dia = $dado['dia'];
      }

      $nomeArquivo = $dia."-".$mes."-".$ano;

      $diretorio = gravar($dado['codigos'], $nomeArquivo, $nomePasta);

      $zip->addFile($diretorio, $nomeArquivo.".txt");

    }

    $zip->close();

    $nomePasta = "downloads/".$mes."-".$ano;
    baixarArquivo($nomePasta."/consulta_local.zip");

  } else {
    echo 0;
  }

?>
