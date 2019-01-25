<?php

    // PDO::FETCH_NUM returns enumerated array
    // PDO::FETCH_ASSOC returns associative array
    // PDO::FETCH_BOTH - both of the above
    // PDO::FETCH_OBJ returns object
    // PDO::FETCH_LAZY

    /**
     * ### **CONSTRUTOR DE QUERYS**
     * 
     * Manipula e constrói querys SQL
     */
    class Query{
        protected $query;
        protected $db;
        protected $valores;

        function __construct(){
            $this->query = null;
            $this->db = null;
            $this->valores = [];
        }

        // ---------------------------------

        /**
         * ### **FUNÇÃO É ARRAY**
         * - Entrada: ["Felipe", "Joao", "Ana"]
         * - Saída: "Felipe, Joao, Ana"
         * 
         * @param array $array
         * 
         * @return string
         */
        private function ehArray($array){
            if(is_array($array)){
                $array = implode(", ", $array);
            }

            return $array;
        }  

        /**
         * ### **FUNÇÃO VALOR**
         * Chamada de exemplo: valor("YEAR(data)", "2019")
         * 
         * $valores += ["YEARdata" => "2019"]
         * 
         * retorno ":YEARdata"
         * 
         * @param string $linhas
         * @param string $valor
         * 
         * @return string
         */
        function valor($linha, $valor){
            $parametro = preg_replace("/[^[:alnum:]_]/", "", $linha);

            if(isset($this->valores[$parametro])){
                $this->valores[$parametro] = $valor;
            } else {
                $this->valores += [$parametro => $valor];
            }

            return ":".$parametro;
        }

        /**
         * Trata os valores passados para executar a query com segurança
         * 
         * Chamada de exemplo: valores_para_inserir(["data" => "2019-01-24", "manha" => 0, "tarde" => 0, "noite" => 0]);
         * 
         * Retorno: ":data, :manha, :tarde, :noite";
         * 
         * @param array $valores
         * 
         * @return string
         */
        private function valores_para_inserir($valores){
            $retorno = [];
            
            foreach($valores as $chave=>$valor){
                $retorno[] = $this->valor($chave, $valor);
            }

            return $this->ehArray($retorno);
        }

        /**
         * 
         * Chamada de exemplo: valores_para_alterar(["data" => "2019-01-24", "nome" => "Felipe"]);
         * 
         * Retorno: "data = :data, nome = :nome";
         * 
         * @param array $valores
         * 
         * @return string
         */
        private function valores_para_alterar($valores){
            $retorno = [];

            foreach($valores as $chave=>$valor){

                if(strpos($valor, "@") !== false){
                    preg_match('/@(.*?)@/', $valor, $resultado);
                    $retorno[] = "$chave = ".$resultado[1];
                    
                    continue;
                }

                $retorno[] = "$chave = ".$this->valor($chave, $valor);
            }

            return $this->ehArray($retorno);
        }

        // ---------------------------------

        /**
         * Chamada de exempço: inserir("cadastros", ["teste1", "teste2", "teste3"]);
         * 
         * Query formada: INSERT cadastros VALUES ("teste1", "teste2", "teste3");
         * 
         * @param string $tabela
         * @param array $valores
         * 
         * @return void
         */
        function inserir($tabela, $valores){

            $valores = $this->valores_para_inserir($valores);
            $this->query = "INSERT $tabela VALUES ($valores)";

        }

        /**
         * Chamada de exemplo: selecionar("cadastros", "*", "usuario = 'Felipe' ");
         * 
         * Query formada: SELECT * FROM cadastros WHERE usuario = 'Felipe';
         * 
         * @param array|string $tabelas
         * @param array|string $colunas
         * @param string $condicao
         * 
         * @return void
         */

        function selecionar($tabelas, $colunas, $condicao){
            $tabelas = $this->ehArray($tabelas);
            $colunas = $this->ehArray($colunas);

            $this->query = "SELECT $colunas FROM $tabelas";

            if($condicao !== null){
                $this->query .= " WHERE $condicao";
            }
        }

        /**
         * Chamada de exemplo: alterar("cadastro", ["data" => "2019-01-24", "nome" => "Felipe"]);
         * 
         * Query formada: UPDATE cadastro SET (data = "2019-01-24", nome = "Felipe");
         * 
         * @param string $tabela
         * @param array $valores
         * 
         * @return void
         */
        function alterar($tabela, $valores, $condicao){
            $valores = $this->valores_para_alterar($valores);
            
            $this->query = "UPDATE $tabela SET $valores";

            if($condicao !== null){
                $this->query .= " WHERE $condicao";
            }
        }

        /**
         * #### **FUNÇÃO EXCLUIR**
         * Chamada de exemplo: excluir("cadastros", "usuario = 'Felipe' ");
         * 
         * Query formada: DELETE FROM cadastros WHERE usuario = 'Felipe';
         * 
         * @param string tabela
         * @param string condicao
         * 
         * @return void
         */
        function excluir($tabela, $condicao){
            
            $this->query = "DELETE FROM $tabela WHERE $condicao";

        }

        // ---------------------------------

        /**
         * ### **FUNÇÃO BANCO**
         * Cria PDO com dados do banco de dados e o retorna
         *  
         * @return object
         */
        private function banco(){
            $banco = new PDO('mysql:host=' . DB_MAIN . ';dbname=' . DB_MAIN_NAME . ';charset=utf8', DB_MAIN_USR, DB_MAIN_PASS);
  
		    return $banco;
        }
        
        /**
         * ### **FUNÇÃO PREPARA QUERY**
         * Prepara a query através do PDO e retorna a query pronta para executar
         *  
         * @return object
         */
        private function preparar_query(){

            $banco = $this->banco();
            $pronta = $banco->prepare($this->query);
            return $pronta;
            
        }

        /**
         * #### **FUNÇÃO EXECUTAR**
         * Executar Query
         * 
         * @return bool
         */
        function executar(){
            $this->db = $this->preparar_query();

            $valores = $this->valores;
            $this->valores = [];

            if(!$this->db->execute($valores)){
                return false;
            }

            return true;
        }

        /**
         * ### **FUNÇÃO TESTAR**
         * Testar a query e imprimir informações passadas
         * 
         * ! EXCLUIR APÓS TESTES
         */

        function testar(){
            echo $this->query."<br><br>\n\n";
            echo var_dump($this->valores);
            echo "<br><br>\n\n";

            $this->db = $this->preparar_query();

            if(!$this->db->execute($this->valores)){
                print_r($this->db->errorInfo());
            } else {
                echo "TESTE PASSOU";
            }
            
        }

        // ---------------------------------

        /**
         * ### **FUNCAO ASSOCIATIVE ARRAY**
         * Retorna array associativo da query
         * 
         * 
         * Exemplo: ["usuario" => "Felipe"]
         * 
         * @return array|bool
         */
        function assoc_array(){
            $itens = [];
            while($item = $this->db->fetch(PDO::FETCH_ASSOC)){
                $itens[] = $item;        
            }

            if(count($itens) == 0){
                return false;
            }

            return $itens;
        }

    }