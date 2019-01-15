<?php
    /*
      PDO::FETCH_NUM returns enumerated array
      PDO::FETCH_ASSOC returns associative array
      PDO::FETCH_BOTH - both of the above
      PDO::FETCH_OBJ returns object
      PDO::FETCH_LAZY
    */

    include "funcoes.php";
  
    // INSERT INTO x (x, z, y) VALUES (:x, :z, :y);
    function db_insert($tabela, $valores){
        $campos = insert_values($valores);

        $query = "INSERT INTO {$tabela} {$campos[0]} VALUES {$campos[1]};";
    
        $db = db_prepare($query);
        if($db->execute($valores)){
            return true;
        } else {
            return false;
        }
    }

    //UDPDATE $db SET variaveis[1] = :valores[1], :variaveis[2] = :valores[2] WHERE id = $id;
    //['nome' => 'Novo Nome' ...] ($dados)
    //['key', 'value'] ($chave)
    function db_edit($tabela, $dados, $chave){
        $query = "UPDATE {$tabela} SET ".update_values($dados)." WHERE {$chave[0]} = '{$chave[1]}'";
        $db = db_prepare($query);
        if($db->execute($dados)){
           return true;
        } else {
           return false;
        }
  
    }

    /*
        SELECT COUNT(data) FROM e_usuarios WHERE '12/12/2018' = '12/12/2018'
        $tabela --> "e_usuarios"
        $coluna --> "data"
        $chave --> ["data", "2018-12-12"]
    */
    function db_countRows($tabela, $coluna, $chave){
        $query = "SELECT COUNT({$coluna}) FROM {$tabela} WHERE {$chave[0]} = '{$chave[1]}'";
        $db = db_prepare($query);
        $db->execute();
        return $db->fetch(PDO::FETCH_NUM);
    }

    /*
        $turno --> "manha"
        $dados --> ["quantidade" => 1, "data" => $hoje]
    */
    function db_contador($turno, $dados){
        $query = "UPDATE e_usuarios SET {$turno} = {$turno}+:quantidade WHERE data = :data";
        $db = db_prepare($query);
        if($db->execute($dados)){
           return true;
        } else {
           return false;
        }
    }

    /*
        CONSULTAS USUÁRIOS 
    */
    function autenticarUsuario($usuario, $senha){
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha AND stat = 1";
        $db = db_prepare($query);

        if($db->execute(["usuario" => $usuario, "senha" => $senha])){
            return $db->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
        
    }

    function checkUsuario($usuario, $nivel){
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $db = db_prepare($query);
        $db->execute(["usuario" => $usuario]); 
        $resposta = $db->fetch(PDO::FETCH_ASSOC);

        if($nivel != null or $nivel != 0){
            if($resposta["nivel"] > $nivel and $resposta["stat"] == 1){
                return true;
            } else {
                return false;
            }
        }

        return $resposta;
    }

    /* NEW */

    class Query{
        protected $query;
        protected $db;
        protected $valores;

        function __construct(){
            $this->query = null;
            $this->db = null;
            $this->valores = [];
        }

        /*
            NOVAS FUNÇÕES 14/01/2019
        */

        function selecionar($tabelas, $colunas, $condicao){
            if(is_array($tabelas)){
                $tabelas = implode(", ", $tabelas);
            }

            if(is_array($colunas)){
                $colunas = implode(", ", $colunas);
            }


            $this->query = "SELECT $tabelas FROM $colunas";

            if($condicao !== null){
                $this->query .= " WHERE $condicoes";
            }
        }

        function executar(){
            $this->db = db_prepare($this->query);
            if(!$this->db->execute($this->valores)){
                return false;
            }

            return $this;
        }

        function valor($linha, $valor){
            $parametro = sha1($linha);
            $this->valores += [$parametro => $valor];

            return ":".$parametro;
        }


        function assoc_array(){
            $itens = [];
            while($item = $this->db->fetch(PDO::FETCH_ASSOC)){
                $itens[]= $item;        
            }

            return $itens;
        }



        /*
            FUNÇÕES QUE SERÃO REMOVIDAS
            ---
        */
        function select($tabelas, $colunas){
            $this->query = "SELECT ".implode(", ", $colunas)." FROM ".implode(", ", $tabelas)." WHERE ";
            return $this;
        }

        function insert($tabela, $values){
            $this->query = "INSERT INTO {$tabela} VALUES ".$this->itens($values).";";
            return $this;
        }

        function update($tabela){
            $this->query = "UPDATE {$tabela} SET ";
            return $this;
        }

        function alterar($tabela, $dados){
            $this->query = "UPDATE $tabela SET ";

            foreach ($dados as $key => $value){
                $this->parametro($key, "=", $value);
                $this->query .= ", ";
            }

            $this->query = substr_replace($this->query, "", -2);

            return $this;
        }

        function deletar($tabela, $id, $key){
            $this->query = "DELETE FROM $tabela WHERE ";
            $this->parametro($id, "=", $key);

            return $this;
        }
        
        function addQuery($query){
            $this->query = $query;
            return $this;
        }

        function where(){
            $this->query .= " WHERE ";
            return $this;
        }

        function quando(){
            $this->query .= " WHERE ";
            return $this;
        }

        function itens($valores){
            #["07-01-2019", "0", "0", "0"] ---> (:07012019, :0, :0, :0)

            $str = "(";

            foreach($valores as $item){
                $str .= ":".sha1($item).", ";
                $this->valores += [sha1($item) => $item];
            }

            return substr_replace($str, ")", -2);
        }

        function parametro($linha, $cond, $valor){
            $parametro = sha1($linha);

            $this->query .= "{$linha} {$cond} :{$parametro}";
            $this->valores += [$parametro => $valor];
            return $this;
        }

        function parametro_direto($linha, $cond, $valor){
            $this->query .= "{$linha} {$cond} {$valor}";
            return $this;
        }

        function and(){
            $this->query .= " AND ";
            return $this;
        }

        function e(){
            $this->query .= " AND ";
            return $this;
        }

        function construir(){
            $this->db = db_prepare($this->query);
            if(!$this->db->execute($this->valores)){
                return false;
            }
            return $this;
        }

        function construir_direto(){
            $this->db = db_prepare($this->query);
            if(!$this->db->execute()){
                return false;
            }
            return $this;
        }

        function testar(){
            $this->db = db_prepare($this->query);
            print_r($this->db->execute($this->valores)->getMessage());
        }

        function array_num(){
            return $this->db->fetch(PDO::FETCH_NUM);
        }

        function array_assoc(){
            return $this->db->fetch(PDO::FETCH_ASSOC);
        }

        function array_assoc_multi(){
            $itens = [];
            while($item = $this->db->fetch(PDO::FETCH_ASSOC)){
                $itens[]= $item;        
            }

            return $itens;
        }

        function array_obj(){
            return $this->db->fetch(PDO::FETCH_OBJ);
        }

        function retornarQuery(){
            return $this->query;
        }

        function print(){
            echo $this->query;
        }

        function print_assoc($value){
            $values = $this->array_assoc();
            echo $values[$value];
        }

        function print_valores(){
            echo var_dump($this->valores);
        }

    }

    function inserir_padrao($tabela, $valores){
        $sql = new Query;

        if($sql->insert($tabela, $valores)->construir()){
            return true;
        }

        return false;
    }


