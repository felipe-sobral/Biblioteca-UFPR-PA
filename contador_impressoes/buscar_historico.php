<?php

  session_start();

  include "../cfg.php";
  include "../funcoesGerais.php";

  $ano = preg_replace('/[^0-9_]/', '',$_POST['ano']);
  $mes = preg_replace('/[^0-9_]/', '',$_POST['mes']);

  $total = 0;

  $sql = mysqli_query($conectar, "SELECT * FROM impressao WHERE ano=$ano AND mes=$mes");
  $verificar_existe = mysqli_num_rows($sql);

  if($verificar_existe==0){
    echo 0;
    exit;
  }

  gravar_log("Consultou estatística impressão [".$mes."-".$ano."] * [#142#]");

  printf("

            <table class='responsive-table'>
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>

  ");
  while($dado = mysqli_fetch_array($sql)){

    if($dado['total'] == 0){

      $data = $dado['xdata'];
      mysqli_query($conectar, "DELETE FROM impressao WHERE xdata='{$data}'");

    } else {

      printf("

            <tr>
              <td>%s</td>
              <td>%d</td>
            </tr>

      ", $dado['xdata'], $dado['total']);

      $total = $total + $dado['total'];

    }

  }

  printf("
        <tr style='background-color: #dee2e8; font-weight: bold;'>
          <b>
          <td>TOTAL</td>
          <td>%d</td>
          </b>
        </tr>

       </tbody>
      </table>

  ",  $total);
?>
