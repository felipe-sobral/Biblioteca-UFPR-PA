<?php

   class Formulario{

      private $comeco;
      private $fim;
      private $linhas;

      function __construct($id){
         $this->comeco = "<div class='row'><form id='$id' class='col s12'>";
         $this->fim = "</form></div>";
      }

      function caixa($id, $nome, $tipo, $placeholder, $valor, $tamanho){
         $ativo = "";

         if($valor != null){
            $ativo = "class='active'";
         }

         return   "
                     <div class='input-field col s$tamanho'>
                        <input placeholder='$placeholder' id='$id' type='$tipo' value='$valor'>
                        <label for='$id' $ativo>$nome</label>
                     </div>
                  ";

      }

      function selecionar($id, $nome, $itens, $tamanho){
         $conteudo = "";

         foreach($itens as $item){
            $conteudo .= $item;
         }

         return "
         
                  <div id='$id' class='input-field col s$tamanho'>
                     <select>$conteudo</select>
                     <label>$nome</label>
                  </div>
         
                ";
      }

      function opcao($valor, $termos, $texto){
         return "<option value='$valor' $termos>$texto</option>";
      }

      function switch($id, $off, $on){

         return "
                  <div class='switch'>
                     <label>
                        $off  
                        <input id='$id' type='checkbox'>
                        <span class='lever'></span>
                        $on
                     </label>
                  </div>
                ";

      }

      function botao_enviar($texto){

         return "<br><button type='submit' class='btn waves-effect waves-light'>$texto</button>";

      }

      function item_customizado($n){
         return $n;
      }

      function linha($itens){
         $conteudo = "";

         foreach($itens as $item){
            $conteudo .= $item;
         }

         $this->linhas .= "<div class='row centralizar'>$conteudo</div>";
      }

      function print(){
         echo $this->comeco.$this->linhas.$this->fim;
      }

   }