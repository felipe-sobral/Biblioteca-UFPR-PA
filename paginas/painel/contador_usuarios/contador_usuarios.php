<?php
   require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
   require_once FORMULARIO;
   require_once AUTENTICACAO;
   require_once HTML;

   if(restrito(2)){
      $cabecalho = file_get_contents("../../corpo/cabecalho.html");
      $rodape = file_get_contents('../../corpo/rodape.html"');
   } else {
      retorna(false, "ACESSO NEGADO");
      exit;
   }

   imprimir_html($cabecalho);

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

   <ul id="tabs-swipe-demo" class="tabs" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed">
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
      
      <div class="center-align z-depth-3" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">group_add</i>
         <h1 class="thin">Contador de usuários</h1>
      </div>
      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card" style="background-image: url('http://localhost/paginas/imagens/bg.jpg')">
                  <div class="barra"></div>
                  <div class="card-content">
                     <h1 id="contador">00</h1>
                     <span class="card-title"><?php echo date('d/m/Y'); ?></span>
                  </div>
                  <div style="padding-bottom: 25px">
                     <a class="waves-effect waves-light btn green" onClick="atualizarContador(1)"><i class="material-icons">add</i></a>
                     <a class="waves-effect waves-light btn red" onClick="atualizarContador(-1)"><i class="material-icons">remove</i></a>
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

      <div class="center-align z-depth-3" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">add</i>
         <h1 class="thin">Adicionar estatística do dia</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="card">
            <div class="barra"></div>

            <?php
               $f = new FormularioComJquery('form_ADICIONAR_CU');

               $f->linha([
                  $f->caixa("ADICIONAR_CU_manha", "Manhã", "number", " min='0' ", 4),
                  $f->caixa("ADICIONAR_CU_tarde", "Tarde", "number", " min='0' ", 4),
                  $f->caixa("ADICIONAR_CU_noite", "Noite", "number", " min='0' ", 4)
               ]);

               $f->linha([
                  $f->caixa("ADICIONAR_CU_dia", "Dia", "number", " min='0' max='32' ", 4),
                  $f->selecionar("ADICIONAR_CU_mes", "Mês", $meses, 4),
                  $f->caixa("ADICIONAR_CU_ano", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
               ]);

               $f->linha([$f->botao_enviar("INSERIR")]);

               $f->print();

               $chaves = [
                  "cod" => $f->tabela("e_usuarios"),
                  "data" => "formatarData($('#ADICIONAR_CU_dia').val(), $('#ADICIONAR_CU_mes').val(), $('#ADICIONAR_CU_ano').val())",
                  "manha" => $f->valor("ADICIONAR_CU_manha"),
                  "tarde" => $f->valor("ADICIONAR_CU_tarde"),
                  "noite" => $f->valor("ADICIONAR_CU_noite")
               ];
                  
               $f->criar_chamada($f->item("http://localhost/root/scripts/AA_adicionar.php"), $chaves, 
                  "console.log(retorno)"
               );
            ?>

         </div>
                  
      </div>
      
   </div>

   <!--
      HISTÓRICO
   -->
   <div id="h">
      
      <div class="center-align z-depth-3" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed;  padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">history</i>
         <h1 class="thin">Histórico</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card">
                  <div class="barra"></div>

                  <?php
                     $at = new FormularioComJquery("form_historico_CU");

                     $at->linha([
                        $at->selecionar("mes_historico_CU", "Mês", $meses, 6),
                        $at->caixa("ano_historico_CU", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 6),
                     ]);

                     $at->linha([$at->botao_enviar("BUSCAR")]);

                     $at->print();

                     $chaves = [
                        "cod" => $at->tabela("e_usuarios"),
                        "mes" => $at->valor("mes_historico_CU"),
                        "ano" => $at->valor("ano_historico_CU")
                     ];
                     
                     $at->criar_chamada($at->item("http://localhost/root/scripts/AA_historico.php"), $chaves, 
                        "
                           if(retorno != \"#false\"){
                              toastTrue();
                     
                              $(\"#historicoLista\").html(retorno);
                                document.getElementById(\"aposProcurar\").style.display = \"block\";
                           } else {
                              toastFalse();
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
   
      <div class="center-align z-depth-3" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed;  padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">edit</i>
         <h1 class="thin">Alterar data</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="card">
            <div class="barra"></div>
                  
               <?php
                  $at = new FormularioComJquery('form_ALTERAR_CU');

                  $at->linha([
                     $at->caixa("ALTERAR_CU_dia", "Dia", "number", " min='0' max='32' ", 4),
                     $at->selecionar("ALTERAR_CU_mes", "Mês", $meses, 4),
                     $at->caixa("ALTERAR_CU_ano", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
                  ]);

                  $at->linha([$at->botao_enviar("BUSCAR")]);

                  $at->print();

                  $chaves = [
                     "cod" => $at->tabela("e_usuarios"),
                     "dia" => $at->valor("ALTERAR_CU_dia"),
                     "mes" => $at->valor("ALTERAR_CU_mes"),
                     "ano" => $at->valor("ALTERAR_CU_ano"),
                     "stat" => $at->item("BUSCAR")
                  ];
                  
                  $at->criar_chamada($at->item("http://localhost/root/scripts/AA_alterar.php"), $chaves, 
                     "if(retorno != '#false'){
                        toastTrue();
                     
                        $('#aposProcurarAlterar').html(retorno);
                        document.getElementById('aposProcurarAlterar').style.display = 'block';
                     } else {
                        toastFalse();
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
      atualizarContador(0);
      $('select').material_select();
   });
</script>

<?php

   imprimir_html($rodape);