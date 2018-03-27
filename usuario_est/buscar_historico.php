<?php

  session_start();

  include "../cfg.php";

  $mes = $_POST['mesHistorico'];
  $ano = $_POST['anoHistorico'];

  $sql = mysqli_query($conectar, "SELECT * FROM estatistica_usuarios WHERE ano='{$ano}' AND n_mes='{$mes}'");
  $verificar_existe = mysqli_num_rows($sql);

  if($verificar_existe==0){
    echo 0;
    exit;
  }

  $manha = 0;
  $tarde = 0;
  $noite = 0;
  $total = 0;

  printf("

          <table class='table table-hover'>
            <thead>
              <tr>
                <th scope='col'>Data</th>
                <th scope='col'>Manha</th>
                <th scope='col'>Tarde</th>
                <th scope='col'>Noite</th>
                <th scope='col'>Total</th>
                </tr>
                </thead>
                <tbody>

  ");
  while($dado = mysqli_fetch_array($sql)){

    if(($dado['manha']+$dado['tarde']+$dado['noite']) == 0){

      $data = $dado['data'];
      mysqli_query($conectar, "DELETE FROM estatistica_usuarios WHERE data='{$data}'");

    } else {

      printf("

            <tr>
              <td>%s</td>
              <td>%d</td>
              <td>%d</td>
              <td>%d</td>
              <td>%d</td>
            </tr>

      ", $dado['data'], $dado['manha'], $dado['tarde'], $dado['noite'], $dado['manha']+$dado['tarde']+$dado['noite']);

      $manha = $manha + $dado['manha'];
      $tarde = $tarde + $dado['tarde'];
      $noite = $noite + $dado['noite'];
      $total = $total + ($dado['manha']+$dado['tarde']+$dado['noite']);

    }

  }

  printf("
        <tr class='bg-primary text-light'>
          <td>TOTAL</td>
          <td>%d</td>
          <td>%d</td>
          <td>%d</td>
          <td>%d</td>
          </tr>

       </tbody>
      </table>

  ",  $manha, $tarde, $noite, $total);



?>
