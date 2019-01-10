<?php

   class Formulario{

      public $id;
      private $comeco;
      private $fim;
      private $linhas;

      function __construct($id){
         $this->id = $id;
         $this->comeco = "<form id='$id'><div class='card-content black-text'>";
         $this->fim = "</div></form>";
      }

      function caixa($id, $nome, $tipo, $adicional, $tamanho){
         $ativo = "";

         if(strpos($adicional, "value") !== false || strpos($adicional, "placeholder") !== false){
            $ativo = "class='active'";
         }

         return   "
                     <div class='input-field col s$tamanho'>
                        <input id='$id' type='$tipo' $adicional>
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
         
                  <div class='input-field col s$tamanho'>
                     <select id='$id'>$conteudo</select>
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
                  </div><br>
                ";

      }

      function botao_enviar($texto){

         return "<button type='submit' class='btn waves-effect waves-light'>$texto</button>";

      }

      function item_customizado($n){
         return $n;
      }

      function linha($itens){
         $conteudo = "";
         $class = "";

         if(isset(func_get_args()[1])){
            $class = func_get_args()[1];
         }

         foreach($itens as $item){
            $conteudo .= $item;
         }

         $this->linhas .= "<div class='row $class'>$conteudo</div>";
      }

      function print(){
         echo $this->comeco.$this->linhas.$this->fim;
      }
   }

   class FormularioComJquery extends Formulario{

      function criar_chamada($endereco, $itens, $retorno){
         

         $js = "
         <script> $('#".$this->id."').submit(function(){ $.post($endereco, { ".$this->param($itens)." }, function(retorno){ $retorno }); return false;}); </script>
         ";

         echo $js;
      }

      private function param($itens){
         $parametros = "";

         foreach($itens as $chave=>$valor){
            $parametros .= "$chave: $valor, ";
         }

         return substr_replace($parametros, "", -2);
      }

      function item($x){
         return "'$x'";
      }

      function tabela($tabela){
         return "'".sha1($tabela)."'";
      }

      function valor($id){
         return "$('#$id').val()";
      }

   }