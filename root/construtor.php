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

      protected $tabela;
      protected $data_tabela;

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
            echo "{\"status\": true, \"mensagem\": \"INSERIDO COM SUCESSO!\"}";
            exit;
         } else {
            echo "{\"status\": false, \"mensagem\": \"#3#\"}";
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
         $form = new FormularioComJquery('form_EU_editar');

         $form->linha([
                     $form->caixa("EU_ed_manha", "Manhã", "number", "value='".$itens['manha']."' min='0'", 4),
                     $form->caixa("EU_ed_tarde", "Tarde", "number", "value='".$itens['tarde']."' min='0'", 4),
                     $form->caixa("EU_ed_noite", "Noite", "number", "value='".$itens['noite']."' min='0'", 4),
                  ]);
         
         $form->linha([
                     $form->caixa("EU_ed_data", "Data", "text", "disabled value='".$itens['data']."'", 12)
                  ]);
                            
         $form->linha([
                     $form->switch("EU_ed_deletar", "Alterar", "Deletar"),
                     $form->botao_enviar("SUBMETER")
                  ], "centralizar");

         

         $form->print();

         $chaves = [
            "cod" => $form->tabela("e_usuarios"),
            "data" => $form->valor("EU_ed_data"),
            "manha" => $form->valor("EU_ed_manha"),
            "tarde" => $form->valor("EU_ed_tarde"),
            "noite" => $form->valor("EU_ed_noite"),
            "deletar" => "$('#EU_ed_deletar').is(':checked')",
            "stat" => $form->item("ALTERAR")
         ];
         $form->criar_chamada($form->item("../root/funcoes/alterar.php"), $chaves, "console.log(retorno)");
      }
   }

   class ConsultaLocal extends Construtor{

      function adicionar($dados, $permissao){
         if(!isset($dados["codigo"]) || strlen($codigo) != 8){
            echo "{\"status\": false, \"mensagem\": \"#4#\"}";
            exit;
         }

         $codigo = preg_replace('/[^[:digit:]_]/', '', $dados["codigo"]);

         unset($dados["cod"]);

         inserir_padrao("livros", [$codigo, null, null, null]);
         
         if(!inserir_padrao($this->tabela, [null, $codigo, $dados["data"]])){
            echo "{\"status\": false, \"mensagem\": \"#3#\"}";
            exit;
         } 
         
         echo "{\"status\": true, \"mensagem\": \"CODIGO REGISTRADO!\"}";
         exit;
         
      }

      function atualizar($data){
         $query = new Query;

         $v_data = $query->valor("data", $data);

         $query->selecionar("consulta_local", "LIVROS_codigo", "data = $v_data ORDER BY id DESC LIMIT 5");
         
         if($query->executar()){
            $mensagem = "";
            
            foreach($query->assoc_array() as $key){
               $mensagem .= $key['LIVROS_codigo']."<br>";
            }

            echo "{\"div\": \"historicoCodigos\", \"mensagem\": \"$mensagem\"}";
         }

         
         exit;
      }

      function tabela($itens){
         $tabela = new Tabela(["Data", "Registros"]);
         $total = 0;

         foreach($itens as $item){
            $data = new DateTime($item['data']);
            $registros = $item['COUNT(*)'];

            $total += $registros;
            $tabela->addItem([$data->format('d/m/Y'), $registros]);
         }

         $tabela->addItem(["<strong>TOTAL</strong>", "$total"]);

         $tabela->print();
      }

      function historico($condicoes, $permissao){
         if(!isset($condicoes, $condicoes['mes'], $condicoes['ano'])){
            echo "{\"status\": false, \"mensagem\": \"#4#\"}";
            exit;
         }

         $sql = new Query;

         $v_mes = $sql->valor("mes", $condicoes['mes']);
         $v_ano = $sql->valor("ano", $condicoes['ano']);

         $itens = [];

         for($i = 1; $i < 33; $i++){
            $v_dia = $sql->valor("dia", $i);
            $sql->selecionar($this->tabela, ["data", "COUNT(*)"], "DAY(data) = $v_dia AND MONTH(data) = $v_mes AND YEAR(data) = $v_ano");
            $sql->executar();
            $item = $sql->array_assoc();

            if($item["data"] !== null && $item["COUNT(*)"] !== 0){
               $itens[] = $item;
            } 
         }

         if($itens === null){
            echo "{\"status\": false, \"mensagem\": \"#5#\"}";
            exit;
         }

         $this->data_tabela = $itens;
      }

   }