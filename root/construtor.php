<?php

   function lista_tabelas($cod){
      $tabelas = [sha1("consulta_local") => "consulta_local",
                  sha1("e_usuarios")     => "e_usuarios", 
                  sha1("livros")         => "livros",
                  sha1("log")            => "log",
                  sha1("usuarios")       => "usuarios"];

      foreach($tabelas as $sha1 => $tabela){
         if($cod == $sha1){
            return $tabela;
         }
      }


      echo "#2#";
      exit;
   }


   class Construtor{

      private $tabela;
      private $data_tabela;

      private function verificar_tabela($tabela){
         if($tabela != null){
            
            $this->tabela = lista_tabelas($tabela);

         } else {
            echo "#1#";
            exit;
         }

      }

      function __construct($tabela){

         $this->verificar_tabela($tabela);

      }

      function adicionar($dados, $permissao){

         if(inserir_padrao($this->tabela, $dados)){
            echo "#true";
            exit;
         } else {
            echo "#3#";
            exit;
         }

      }

      function historico($condicoes, $permissao){
         $sql = new Query;

         if(!isset($condicoes, $condicoes['mes'], $condicoes['ano'])){
            echo "#4#";
            exit;
         }

         if($sql->select([$this->tabela], ['*'])->parametro('MONTH(data)', '=', $condicoes['mes'])->and()->parametro('YEAR(data)', '=', $condicoes['ano'])->construir()){

            $itens = $sql->array_assoc_multi();

            if($itens == null){
               echo "#5#";
               exit;
            }

            $this->data_tabela = $itens;
            
         }
      }

      function get_dataTabela(){
         return $this->data_tabela;
      }

      function buscar($dados, $permissao){

         if(!isset($dados['dia'], $dados['mes'], $dados['ano'])){
            echo "#false";
            exit;
         }
   
         $query = new Query;
         if($query->select([$this->tabela], ['*'])
                ->parametro('DAY(data)', '=', $dados['dia'])
                ->and()
                ->parametro('MONTH(data)', '=', $dados['mes'])
                ->and()
                ->parametro('YEAR(data)', '=', $dados['ano'])
                ->construir()){
            
            $dia = $query->array_assoc();
   
            if($dia == null){
               echo "#4#";
               exit;
            }   
         }

         return $dia;
      }

      function alterar($dados, $permissao){

         if(!isset($dados['data'])){
            echo "#false";
            exit;
         } else {
            $data = $dados['data'];
            unset($dados['data']);
         }

         $query = new Query;

         if(isset($dados['deletar'])){
            if($dados['deletar'] == "true"){
               if($query->deletar($this->tabela, "data", $data)->construir()){
                  echo "#true";
                  exit;
               }
            } else {
               unset($dados['deletar']);
            }
         }

         
         if($query->alterar($this->tabela, $dados)
                  ->quando()
                  ->parametro("data", '=', $data)
                  ->construir()){
            
            echo "#true";
            exit;
         }
         
      }
   }

   class EstatisticaUsuarios extends Construtor{

      function contar(){

      }

      function tabela($itens){
         $tabela = new Tabela(["Data", "Manhã", "Tarde", "Noite", "Total"]);
         $totais = [0, 0, 0];
   
         foreach($itens as $item){
            $data = new DateTime($item['data']);
            $total = $item['manha']+$item['tarde']+$item['noite'];
   
            $totais[0] += $item['manha'];
            $totais[1] += $item['tarde'];
            $totais[2] += $item['noite'];
   
            $tabela->addItem([$data->format('d/m/Y'), $item['manha'], $item['tarde'], $item['noite'], $total]);
         }
   
         $tabela->addItem(["<strong>TOTAL</strong>", "$totais[0]", "$totais[1]", "$totais[2]", $totais[0]+$totais[1]+$totais[2]]);
   
   
         $tabela->print();
      }

      function formulario($itens){
         $f = new FormularioComJquery('form_EU_editar');

         $f->linha([
                     $f->caixa("EU_ed_manha", "Manhã", "number", "value='".$itens['manha']."' min='0'", 4),
                     $f->caixa("EU_ed_tarde", "Tarde", "number", "value='".$itens['tarde']."' min='0'", 4),
                     $f->caixa("EU_ed_noite", "Noite", "number", "value='".$itens['noite']."' min='0'", 4),
                  ]);
         
         $f->linha([
                     $f->caixa("EU_ed_data", "Data", "text", "disabled value='".$itens['data']."'", 12)
                  ]);
                            
         $f->linha([
                     $f->switch("EU_ed_deletar", "Alterar", "Deletar"),
                     $f->botao_enviar("SUBMETER")
                  ], $adicional = "centralizar");

         

         $f->print();

         $chaves = [
            "cod" => $f->tabela("e_usuarios"),
            "data" => $f->valor("EU_ed_data"),
            "manha" => $f->valor("EU_ed_manha"),
            "tarde" => $f->valor("EU_ed_tarde"),
            "noite" => $f->valor("EU_ed_noite"),
            "deletar" => "$('#EU_ed_deletar').is(':checked')",
            "stat" => $f->item("ALTERAR")
         ];
         $f->criar_chamada($f->item("../root/funcoes/alterar.php"), $chaves, "console.log(retorno)");
      }
   }

   class ConsultaLocal extends Construtor{

      function adicionar($dados, $permissao){
         if(!isset($dados["codigo"])){
            echo "{\"status\": false, \"mensagem\": \"#4#\"}";
            exit;
         }

         $codigo = preg_replace('/[^[:digit:]_]/', '', $dados["codigo"]);

         if(strlen($codigo) != 8){
            echo "{\"status\": false, \"mensagem\": \"#4#\"}";
            exit;
         }

         $tabela = lista_tabelas($dados["cod"]);
         unset($dados["cod"]);

         inserir_padrao("livros", [$codigo, null, null, null]);
         
         if(inserir_padrao($tabela, [null, $codigo, $dados["data"]])){
            echo "{\"status\": true, \"mensagem\": \"CODIGO REGISTRADO!\"}";
            exit;
         } else {
            echo "{\"status\": false, \"mensagem\": \"#3#\"}";
            exit;
         }
         
      }

      function atualizar($data){
         $q = new Query;

         $v_data = $q->valor("data", $data);

         $q->selecionar("consulta_local", "LIVROS_codigo", "data = '$v_data' ORDER BY LIVROS_codigo DESC LIMIT 3");

         print_r($q->assoc_array());
      }

   }