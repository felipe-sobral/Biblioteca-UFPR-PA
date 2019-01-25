<?php
   class ConsultaLocal extends Construtor{

      function __construct(){
         $this->tabela = "consulta_local";
      }

      /**
       * COLOCAR NO SCRIPT
       */
      function adicionar($dados, $permissao){
         if(!isset($dados["codigo"]) || strlen($dados["codigo"]) != 8){
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

      function formulario($itens){
         $tabela = new Tabela(["Data", "Registros", "Opções"]);

         foreach($itens as $item){
            $data = new DateTime($item['data']);
            $registros = $item['LIVROS_codigo'];
            $botao = "<a class='waves-effect waves-light btn-floating'>
                        <i class='material-icons' onClick='alterarConsultaLocal(".$item['id'].", \"".$item['LIVROS_codigo']."\")'>edit</i>
                     </a>";

            $tabela->addItem([$data->format('d/m/Y'), $registros, $botao]);
         }  

         $tabela->printDiv("div-alterarCL");
      }

      function historico($condicoes){
         if(!isset($condicoes, $condicoes['mes'], $condicoes['ano'])){
            return false;
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
            return false;
         }

         $this->data_tabela = $itens;
      }

   }