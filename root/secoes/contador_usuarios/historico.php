<?php
   session_start();

   if(!isset($_SESSION) or !isset($_SESSION['usuario'])){
      echo "OPS... =(";
      return false;
   }

   require "../../init.php";
   include "../../templates/tabela.php";

   if(!checkUsuario($_SESSION['usuario'], 2)){
      echo "OPS... =(";
      return false;
   }

   $mes = isset($_POST['mes']) ? $_POST['mes']:null;
   $ano = isset($_POST['ano']) ? $_POST['ano']:date('Y');

   if($mes == null){
      echo "#false";
      return false;
   }

   $sql = new Query;


   if($sql->select(['e_usuarios'], ['*'])->parametro('MONTH(data)', '=', $mes)->and()->parametro('YEAR(data)', '=', $ano)->construir()){
      $itens = $sql->array_assoc_multi();

      if($itens == null){
         echo "#false";
         return false;
      }

      $tabela = new Tabela(["Data", "Manhã", "Tarde", "Noite", "Total"]);
      $totais = [0, 0, 0];

      foreach($itens as $item){
         $data = new DateTime($item['data']);
         $total = $item['manha']+$item['tarde']+$item['noite'];

         $totais[0] += $item['manha'];
         $totais[1] += $item['tarde'];
         $totais[2] += $item['noite'];

         $tabela->addItem([$data->format('d/m/Y'), $item['manha'], $item['tarde'], $item['noite'], $total]);
      }

      $tabela->addItem(["<strong>TOTAL</strong>", "$totais[0]", "$totais[1]", "$totais[2]", $totais[0]+$totais[1]+$totais[2]]);


      $tabela->print();
      return;
   } else {
      echo "#false";
      return false;
   }
