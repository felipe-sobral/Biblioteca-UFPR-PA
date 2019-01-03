<?php
   require "../root/init.php";

   session_start();
 
   if(acesso_restrito(2)){
      $cabecalho = file_get_contents('../root/templates/cabecalho.html');
      $rodape = file_get_contents('../root/templates/rodape.html');
      echo $cabecalho;
   } else {
      echo "ERROR";
      return false;
   }

   function drop_mes(){
      echo "
         <option disabled selected>Escolha o mês</option>
         <option value='1'>Janeiro</option>
         <option value='2'>Fevereiro</option>
         <option value='3'>Março</option>
         <option value='4'>Abril</option>
         <option value='5'>Maio</option>
         <option value='6'>Junho</option>
         <option value='7'>Julho</option>
         <option value='8'>Agosto</option>
         <option value='9'>Setembro</option>
         <option value='10'>Outubro</option>
         <option value='11'>Novembro</option>
         <option value='12'>Dezembro</option>
      ";
   }
?>

<!--

   PAINEL DE CONTROLE - Contador Usuários
   ATUALIZADO: 03/01/2018

-->

<div id="main">

   <ul id='menu' class='side-nav fixed'>
      <div id="menuID"></div>
   </ul>

   <ul id="tabs-swipe-demo" class="tabs">
      <li class="tab col s3"><a class="active menu-item" href="#c">Contador</a></li>
      <li class="tab col s3"><a class="menu-item" href="#add">Adicionar</a></li>
      <li class="tab col s3"><a class="menu-item" href="#h">Histórico</a></li>
      <li class="tab col s3"><a class="menu-item" href="#alt">Alterar</a></li>
      <li class="indicator" style="right: 974px;left: 0px; background-color: #404040;"></li>
   </ul>

   <!--
      CONTADOR
   -->
   <div id="c">
      
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">group_add</i>
         <h1 class="thin">Contador de usuários</h1>
      </div>
      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card">
                  <div class="barra"></div>
                  <div class="card-content black-text">
                     <h1 id="contador" style="color: #2d2d2d">00</h1>
                     <span class="card-title"><?php echo date('d/m/Y'); ?></span>
                  </div>
                  <div class="card-action">
                     <a class="waves-effect waves-light btn-large green" onClick="atualizar_contador(1)"><i class="material-icons">add</i></a>
                     <a class="waves-effect waves-light btn-large red" onClick="atualizar_contador(-1)"><i class="material-icons">remove</i></a>
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

      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">add</i>
         <h1 class="thin">Adicionar estatística do dia</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card">
                  <div class="barra"></div>
                  <form id="form_adicionar_dia_EU">
                     <div class="card-content black-text">
                        
                        <div class="row">
                           <div class="input-field col s4">
                              <input type='number' min='0' id='manha'>
                              <label for='manha'>Manhã</label>
                           </div>
                           <div class="input-field col s4">
                              <input type='number' min='0' id='tarde'>
                              <label for='tarde'>Tarde</label>
                           </div>
                           <div class="input-field col s4">
                              <input type='number' min='0' id='noite'>
                              <label for='noite'>Noite</label>
                           </div>
                        </div>

                        <div class="row">
                           <div class="input-field col s4">
                              <input type='number' min='0' max='32' id='dia'>
                              <label for='dia'>Dia</label>
                           </div>
                           <div class="input-field col s4">
                              <select id="mes">
                                 <?php drop_mes() ?>
                              </select>
                              <label>Mês</label>
                           </div>
                           <div class="input-field col s4">
                              <input type='number' min='2018' max='<?php echo date('Y') ?>' id='ano'>
                              <label for='ano'>Ano</label>
                           </div>
                        </div>

                     </div>

                     <div class="card-action">
                        <button type="submit" class="btn waves-effect waves-light">REGISTRAR</button>
                     </div>

                  </form>

               </div>
            </div>
         </div>
                  
      </div>
      
   </div>

   <div id="h">
      
      <div class="center-align z-depth-3" style="background-image: url('../img/bg-azul.jpg'); padding-top: 2%; padding-bottom: 2%">
         <i class="material-icons" style="font-size: 100px">history</i>
         <h1 class="thin">Histórico</h1>
      </div>

      <div class="container center-align" style="margin-top: 5%;">
         
         <div class="row">
            <div class="col s12">
               <div class="card">
                  <div class="barra"></div>
                  <form id="form_historico_EU">
                     <div class="card-content black-text">
                        
                        <div class="row">
                           <div class="input-field col s6">
                              <select id="mes_historico_EU">
                                 <?php drop_mes() ?>
                              </select>
                              <label>Mês</label>
                           </div>

                           <div class="input-field col s6">
                              <input type='number' min='2018' max='<?php echo date('Y') ?>' id='ano_historico_EU'>
                              <label for='ano'>Ano</label>
                           </div>
                        </div>
                     </div>

                     <div class="card-action">
                        <button type="submit" class="btn waves-effect waves-light">BUSCAR</button>
                     </div>

                  </form>

                  <div id="aposProcurar" style="display: none">
                     <hr>
                     <button class="btn waves-effect" onclick="imprimirTabela('historicoLista')"><i class="material-icons">print</i></button>
                     <div id="historicoLista"></div>
                  </div>

               </div>
            </div>
         </div>
                  
      </div>

   </div>

   <div id="alt">Test 4</div>
         
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