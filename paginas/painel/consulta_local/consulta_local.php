<?php
  require_once $_SERVER["DOCUMENT_ROOT"]."/root/init.php";
  require_once FORMULARIO;
  require_once AUTENTICACAO;
  require_once HTML;

  if(restrito(2)){
      $cabecalho = file_get_contents("../../corpo/cabecalho.html");
      $rodape = file_get_contents('../../corpo/rodape.html"');
      $registrar;
   } else {
      retorna(false, "ACESSO NEGADO");
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

   imprimir_html($cabecalho);
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
      <li class="tab col s3"><a class="active menu-item" href="#registrar">Registrar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#historico">Histórico</a></li>
      <li class="tab col s3"><a class="menu-item" href="#alterar">Alterar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#adicionar">Adicionar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#baixar">Baixar</a></li>
      <li class="indicator" style="right: 974px;left: 0px; background-color: #fff;"></li>
   </ul>

   <!--
      REGISTRAR
   -->
   <section id="registrar">
      
      <?php imprimir_html() ?>

   </section>

   <!--
      HISTÓRICO
   -->
   <div id="historico">
      
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
                     $at = new FormularioComJquery('form_historico_CL');

                     $at->linha([
                        $at->selecionar("mes_historico_CL", "Mês", $meses, 6),
                        $at->caixa("ano_historico_CL", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 6)
                     ]);

                     $at->linha([$at->botao_enviar("BUSCAR")]);

                     $at->print();

                     $chaves = [
                        "cod" => $at->tabela("consulta_local"),
                        "mes" => $at->valor("mes_historico_CL"),
                        "ano" => $at->valor("ano_historico_CL")
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
      ADICIONAR REGISTROS
   -->
   <div id="adicionar">

      <div class="center-align z-depth-3" style="background-image: url('http://localhost/paginas/imagens/bg-azul.jpg'); background-attachment: fixed; padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">add</i>
         <h1 class="thin">Adicionar registros</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="card">
            <div class="barra"></div>

            <?php
               $f = new FormularioComJquery('form_adicionar_CL');

               $f->linha([
                  $f->caixa("codigo_add_CL", "Código", "text", null, 12)
               ]);

               $f->linha([
                  $f->caixa("dia", "Dia", "number", " min='0' max='32' ", 4),
                  $f->selecionar("mes", "Mês", $meses, 4),
                  $f->caixa("ano", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
               ]);

               $f->linha([$f->botao_enviar("INSERIR")]);

               $f->print();

               $chaves = [
                  "cod" => $f->tabela("consulta_local_INSERIR"),
                  "id" => "null",
                  "codigo" => $f->valor("codigo_add_CL"),
                  "data" => "dataFormatada($('#dia').val(), $('#mes').val(), $('#ano').val())"
               ];
                  
               $f->criar_chamada($f->item("../root/funcoes/adicionar.php"), $chaves, 
                  "tratarRetorno(retorno)"
               );
            ?>

         </div>
                  
      </div>
      
   </div>

   <!--
      ALTERAR
   -->
   <div id="alterar">
      
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
                     $at = new FormularioComJquery('form_alterar_CL');

                     $at->linha([
                        $at->caixa("dia_alterar_CL", "Dia", "number", " min='0' max='32' ", 4),
                        $at->selecionar("mes_alterar_CL", "Mês", $meses, 4),
                        $at->caixa("ano_alterar_CL", "Ano", "number", " min='2018' max='".date('Y')."' value='".date('Y')."' ", 4),
                     ]);

                     $at->linha([$at->botao_enviar("BUSCAR")]);

                     $at->print();

                     $chaves = [
                        "cod" => $at->tabela("consulta_local"),
                        "dia" => $at->valor("dia_alterar_CL"),
                        "mes" => $at->valor("mes_alterar_CL"),
                        "ano" => $at->valor("ano_alterar_CL"),
                        "stat" => $at->item("BUSCAR")
                     ];
                     
                     $at->criar_chamada($at->item("../root/funcoes/alterar.php"), $chaves, 
                        "tratarRetorno(retorno)"
                     );
                  ?>

                  <div id="div-alterarCL" class="container left-align card-action" style="color: #000"></div>

                  <div id="modalEditar" class="modal">
                     <div class="modal-content" style="color: #000">
                        <?php
                           $at = new FormularioComJquery("form_alterarCod_CL");

                           $at->linha([
                              $at->caixa("id_alterarCod_CL", "ID", "number", "placeholder='ID' disabled", 3),
                              $at->caixa("codigo_alterarCod_CL", "Código", "text", "placeholder='Código'", 9)
                           ]);

                           $at->linha([$at->botao_enviar("ALTERAR"), $at->botao_enviar("EXCLUIR")]);

                           $at->print();

                           $chaves = [
                              "cod" => $at->tabela("consulta_local"),
                              "stat" => $at->valor("ALTERAR"),
                              "id" => $at->valor("id_alterarCod_CL"),
                              "cod" => $at->valor("codigo_alterarCod_CL")
                           ];
                           
                           $at->criar_chamada($at->item("../root/funcoes/alterar.php"), $chaves, 
                              "tratarRetorno(retorno)"
                           );
                        ?>
                     </div>
                  </div>

               </div>
            </div>
         </div>
                  
      </div>

   </div>
      
</div>

<script>
   $(document).ready(function() { 
      $(".button-collapse").sideNav();
      $(".modal").modal();
      $("ul.tabs").tabs();
      $("select").material_select();
      menu();
      atualizarCodigos();
   });
</script>

<?php

   imprimir_html($rodape);