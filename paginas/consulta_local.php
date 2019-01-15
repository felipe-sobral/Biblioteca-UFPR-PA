<?php
   require "../root/init.php";
   include "../root/templates/formulario.php";

   session_start();
 
   if(acesso_restrito(2)){
      $cabecalho = file_get_contents('../root/templates/cabecalho.html');
      $rodape = file_get_contents('../root/templates/rodape.html');
      echo $cabecalho;
   } else {
      echo "ERROR";
      return false;
   }

   $meses = [  
            "<option disabled selected>Mês</option>",
            "<option value='1'>Janeiro</option>",
            "<option value='2'>Fevereiro</option>",
            "<option value='3'>Março</option>",
            "<option value='4'>Abril</option>",
            "<option value='5'>Maio</option>",
            "<option value='6'>Junho</option>",
            "<option value='7'>Julho</option>",
            "<option value='8'>Agosto</option>",
            "<option value='9'>Setembro</option>",
            "<option value='10'>Outubro</option>",
            "<option value='11'>Novembro</option>",
            "<option value='12'>Dezembro</option>"
            ];
?>

<!--

   PAINEL DE CONTROLE - Contador Usuários
   ATUALIZADO: 03/01/2018

-->

<div id="main">

   <ul id='menu' class='side-nav fixed'>
      <div id="menuID"></div>
   </ul>

   <ul id="tabs-swipe-demo" class="tabs" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed">
      <a href="#" data-activates="menu" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons" style="color: #fff">menu</i></a>
      <li class="tab col s3"><a class="active menu-item" href="#c">Registrar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#h">Histórico</a></li>
      <li class="tab col s3"><a class="menu-item" href="#add">Adicionar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#alt">Alterar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#b">Baixar</a></li>
      <li class="indicator" style="right: 974px;left: 0px; background-color: #fff;"></li>
   </ul>

   <!--
      CONTADOR
   -->
   <div id="c">
      
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">note_add</i>
         <h1 class="thin">Registrar códigos</h1>
      </div>
      <div class="container center-align" style="margin-top: 5%; color: #000 !important">
         
         <div class="card">
            <div class="barra"></div>
            <div class='card-content black-text'>
               <div class="row">

                  <div class="col s12">
                     <?php
                        $f = new FormularioComJquery('form_registrar_codigo');

                        $f->linha([
                           $f->caixa("form_rcodigo", "Insira o código", "text", "placeholder='00329902' autofocus", 12),
                        ]);

                        $f->linha([$f->botao_enviar("Registrar")]);

                        $f->print();

                        $chaves = [
                           "cod" => $f->tabela("consulta_local"),
                           "codigo" => $f->valor("form_rcodigo"),
                           "data" => $f->item(date("Y-m-d"))
                        ];
                           
                        $f->criar_chamada($f->item("../root/funcoes/adicionar.php"), $chaves, 
                           "
                           $('#form_rcodigo').val('');
                           $('#form_rcodigo').focus();
                           tratarRetorno(retorno);
                           atualizarCodigos();
                           "
                        );
                     ?>
                  </div>

               </div>
               <hr style="width: 31vw; border-color: #ffffff70;">
               <h3 class="thin">Histórico</h3>
               <div id="historicoCodigos">Nada registrado =(</div>
               <br>
            </div>
         </div>
                  
      </div>

   </div>
      
</div>

<script>
   $(document).ready(function() { 
      $(".button-collapse").sideNav();
      menu();
      $('ul.tabs').tabs();
      $('select').material_select();
      atualizarCodigos();
   });
</script>

<?php

   echo $rodape;