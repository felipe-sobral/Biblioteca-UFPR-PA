<?php

   class Formulario{

      public $ident;
      private $comeco;
      private $fim;
      private $linhas;

      function __construct($ident){
         $this->ident = $ident;
         $this->comeco = "<form id='$ident'><div class='card-content black-text'>";
         $this->fim = "</div></form>";
      }

      function caixa($ident, $nome, $tipo, $adicional, $tamanho){
         $ativo = "";

         if(strpos($adicional, "value") !== false || strpos($adicional, "placeholder") !== false){
            $ativo = "class='active'";
         }

         return   "
                     <div class='input-field col s$tamanho'>
                        <input id='$ident' type='$tipo' $adicional>
                        <label for='$ident' $ativo>$nome</label>
                     </div>
                  ";

      }

      function selecionar($ident, $nome, $itens, $tamanho){
         $conteudo = "";

         foreach($itens as $item){
            $conteudo .= $item;
         }

         return "
         
                  <div class='input-field col s$tamanho'>
                     <select id='$ident'>$conteudo</select>
                     <label>$nome</label>
                  </div>
         
                ";
      }

      function opcao($valor, $termos, $texto){
         return "<option value='$valor' $termos>$texto</option>";
      }

      function switch($ident, $indisp, $disp){

         return "
                  <div class='switch'>
                     <label>
                        $indisp  
                        <input id='$ident' type='checkbox'>
                        <span class='lever'></span>
                        $disp
                     </label>
                  </div><br>
                ";

      }

      function botao_enviar($texto){

         return "<button type='submit' class='btn waves-effect waves-light'>$texto</button>";

      }

      function item_customizado($item){
         return $item;
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
         <script> $('#".$this->ident."').submit(function(){ $.post($endereco, { ".$this->param($itens)." }, function(retorno){ $retorno }); return false;}); </script>
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

      function item($item){
         return "'$item'";
      }

      function tabela($tabela){
         return "'".sha1($tabela)."'";
      }

      function valor($ident){
         return "$('#$ident').val()";
      }

   }