<?php
   /**
    * ### **CLASSE FORMULÁRIO**
    *
    * Fabricar formulários simples
    */
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

      /**
       * ### **FUNÇÃO CAIXA**
       * 
       * Cria campo de texto ou número
       * 
       * @param string $ident ID
       * @param string $nome
       * @param string $tipo
       * @param string $adicional
       * @param int $tamanho Tamanho do componente
       * 
       * @return string
       */
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
      
      /**
       * ### **FUNÇÃO SELECIONAR**
       * 
       * Cria campo para selecionar opções
       * 
       * @param string $ident ID
       * @param string $nome
       * @param array $itens
       * @param int $tamanho Tamanho do componente
       * 
       * @return string
       */
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

      /**
       * ### **FUNÇÃO OPÇÃO**
       * 
       * Cria opção para o componente *selecionar*
       * 
       * @param string $valor
       * @param string $termos
       * @param string $texto
       * 
       * @return string
       */
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

      /**
       * ### **FUNÇÃO ENVIAR**
       * 
       * Cria opção para submeter o formulário
       * 
       * @param string $texto
       * 
       * @return string
       */
      function botao_enviar($texto){

         return "<button type='submit' class='btn waves-effect waves-light'>$texto</button>";

      }

      /**
       * ### **ITEM CUSTOMIZADO**
       * 
       * Recebe um componente de formulário em HTML e o retorna
       * 
       * @param string $item
       * 
       * @return string
       */
      function item_customizado($item){
         return $item;
      }

      /**
       * ### **LINHA**
       * 
       * Constrói uma linha com componentes
       * 
       * Exemplo: [caixa(.., 6), caixa(.., 6) {...}]
       * 
       * @param array $item
       * @param string $class OPCIONAL
       */
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

      /**
       * ### **PRINT**
       * 
       * Imprime formulário
       */
      function print(){
         echo $this->comeco.$this->linhas.$this->fim;
      }

      /**
       * ### **RETORNA FORMULÁRIO**
       * 
       * Retorna código HTML do formulário
       * 
       * @return string
       */
      function retornaForm(){
         return $this->comeco.$this->linhas.$this->fim;
      }

   }

   /**
    * ### **CLASSE FORMULÁRIO COM JQUERY**
    *
    * Fabricar formulários com JQuery
    */
   class FormularioComJquery extends Formulario{

      /**
       * 
       */
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