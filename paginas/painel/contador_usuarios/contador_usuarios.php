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
      <li class="tab col s3"><a class="active menu-item" href="#c">Contador</a></li>
      <li class="tab col s3"><a class="menu-item" href="#h">Histórico</a></li>
      <li class="tab col s3"><a class="menu-item" href="#add">Adicionar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#alt">Alterar</a></li>
      <li class="indicator" style="right: 974px;left: 0px; background-color: #fff;"></li>
   </ul>

   <!--
      CONTADOR
   -->
   <div id="c">
      
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">group_add</i>
         <h1 class="thin">Contador de usuários</h1>
      </div>
      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card" style="background-image: url('../img/bg.jpg')">
                  <div class="barra"></div>
                  <div class="card-content">
                     <h1 id="contador">00</h1>
                     <span class="card-title"><?php echo date('d/m/Y'); ?></span>
                  </div>
                  <div style="padding-bottom: 25px">
                     <a class="waves-effect waves-light btn green" onClick="atualizar_contador(1)"><i class="material-icons">add</i></a>
                     <a class="waves-effect waves-light btn red" onClick="atualizar_contador(-1)"><i class="material-icons">remove</i></a>
                  </div>
               </div>
            </div>
         </div>
                  
      </div>

   </div>

   <!--
      ADICIONAR DIA
   -->
   <div id="add">

      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">add</i>
         <h1 class="thin">Adicionar estatística do dia</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="card">
            <div class="barra"></div>

            <?php
               $f = new FormularioComJquery('form_adicionar_dia_EU');

               $f->linha([
                  $f->caixa("manha", "Manhã", "number", " min='0' ", 4),
                  $f->caixa("tarde", "Tarde", "number", " min='0' ", 4),
                  $f->caixa("noite", "Noite", "number", " min='0' ", 4)
               ]);

               $f->linha([
                  $f->caixa("dia", "Dia", "number", " min='0' max='32' ", 4),
                  $f->selecionar("mes", "Mês", $meses, 4),
                  $f->caixa("ano", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
               ]);

               $f->linha([$f->botao_enviar("INSERIR")]);

               $f->print();

               $chaves = [
                  "cod" => $f->tabela("e_usuarios"),
                  "data" => "dataFormatada($('#dia').val(), $('#mes').val(), $('#ano').val())",
                  "manha" => $f->valor("manha"),
                  "tarde" => $f->valor("tarde"),
                  "noite" => $f->valor("noite")
               ];
                  
               $f->criar_chamada($f->item("../root/funcoes/adicionar.php"), $chaves, 
                  "tratarRetorno(retorno)"
               );
            ?>

         </div>
                  
      </div>
      
   </div>

   <!--
      HISTÓRICO
   -->
   <div id="h">
      
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed;  padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">history</i>
         <h1 class="thin">Histórico</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card">
                  <div class="barra"></div>

                  <?php
                     $at = new FormularioComJquery('form_historico_EU');

                     $at->linha([
                        $at->selecionar("mes_historico_EU", "Mês", $meses, 6),
                        $at->caixa("ano_historico_EU", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 6),
                     ]);

                     $at->linha([$at->botao_enviar("BUSCAR")]);

                     $at->print();

                     $chaves = [
                        "cod" => $at->tabela("e_usuarios"),
                        "mes" => $at->valor("mes_historico_EU"),
                        "ano" => $at->valor("ano_historico_EU")
                     ];
                     
                     $at->criar_chamada($at->item("../root/funcoes/historico.php"), $chaves, 
                        "
                           if(retorno != \"#false\"){
                              criar_toast(\"<i class='material-icons'>check</i>\", 1000, \"toast-verde\");
                     
                              $(\"#historicoLista\").html(retorno);
                                document.getElementById(\"aposProcurar\").style.display = \"block\";
                           } else {
                              criar_toast(\"<i class='material-icons'>close</i>\", 1000, \"toast-vermelho\");
                           }
                        ");
                  ?>

                  <div id="aposProcurar" class="container left-align" style="display: none; color: #000">
                     <button class="btn waves-effect" onclick="imprimirTabela('historicoLista')"><i class="material-icons">print</i></button>
                     <div id="historicoLista" style="padding-top: 20px; padding-bottom: 20px"></div>
                  </div>

               </div>
            </div>
         </div>
                  
      </div>

   </div>

   <!--
      ALTERAR DATA
   -->
   <div id="alt">
   
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); background-attachment: fixed;  padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">edit</i>
         <h1 class="thin">Alterar data</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="card">
            <div class="barra"></div>
                  
               <?php
                  $at = new FormularioComJquery('form_alterar_dia_EU');

                  $at->linha([
                     $at->caixa("dia_alterar_EU", "Dia", "number", " min='0' max='32' ", 4),
                     $at->selecionar("mes_alterar_EU", "Mês", $meses, 4),
                     $at->caixa("ano_alterar_EU", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
                  ]);

                  $at->linha([$at->botao_enviar("BUSCAR")]);

                  $at->print();

                  $chaves = [
                     "cod" => $at->tabela("e_usuarios"),
                     "dia" => $at->valor("dia_alterar_EU"),
                     "mes" => $at->valor("mes_alterar_EU"),
                     "ano" => $at->valor("ano_alterar_EU"),
                     "stat" => $at->item("BUSCAR")
                  ];
                  
                  $at->criar_chamada($at->item("../root/funcoes/alterar.php"), $chaves, 
                     "if(retorno != '#false'){
                     Materialize.toast('<i class=\"material-icons\">check</i>', 1000, 'toast-verde');
                     
                     $('#aposProcurarAlterar').html(retorno);
                     document.getElementById('aposProcurarAlterar').style.display = 'block';
                     } else {
                        Materialize.toast('<i class=\"material-icons\">close</i>', 1000, 'toast-vermelho');
                     }"
                  );
               ?>

               <div id="aposProcurarAlterar" class="container left-align card-action" style="display: none; color: #000"></div>
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
      atualizar_contador(0);
      $('select').material_select();
   });
</script>

<?php

   echo $rodape;