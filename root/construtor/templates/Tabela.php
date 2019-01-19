<?php
   
   class Tabela{
      private $comeco;
      private $fim;
      private $itens;

      function __construct($cabecalho){
         $this->comeco = "<table class='responsive-table striped centered'> <thead> <tr> ".$this->cabecalho($cabecalho)." </tr> </thead> <tbody>";
         $this->fim = "</tbody></table>";
         $this->itens = "";
      }

      private function cabecalho($cabecalho){
         $itens = "";
         foreach($cabecalho as $item){
            $itens .= "<th>$item</th>";

         }
         return $itens;
      }

      function item($valor){
         return "<td>$valor</td>";
      }

      function addItem($valores){
         $linha = "";

         foreach($valores as $valor){
            $linha .= $this->item($valor);
         }

         $this->itens .= "<tr>$linha</tr>";
      }

      function print(){
         echo $this->comeco.$this->itens.$this->fim;
      }

      function printDiv($div){
         //$string = htmlspecialchars($this->comeco.$this->itens.$this->fim, ENT_QUOTES);
         //$string = preg_replace("/\t\n /", "", $this->comeco.$this->itens.$this->fim);
         //$string = str_replace(' ', '', $this->comeco.$this->itens.$this->fim);

         $json = [
            "div" => "$div",
            "mensagem" => $this->comeco.$this->itens.$this->fim
         ];
         //echo "{\"div\": \"$div\", \"mensagem\": \"$string\"}";

         echo json_encode($json);

         
      }
   }

   /*
   $tabela_teste = new Tabela(["dia", "manha", "tarde", "noite"]);

   $tabela_teste->addItem(["2018-01-04", "10", "5", "6"]);
   $tabela_teste->addItem(["2018-01-05", "10", "5", "6"]);
   $tabela_teste->addItem(["2018-01-06", "10", "5", "6"]);
   $tabela_teste->addItem(["2018-01-07", "10", "5", "6"]);
   $tabela_teste->addItem(["2018-01-08", "10", "5", "6"]);

   $tabela_teste->print();
   */