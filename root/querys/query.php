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
        private $query;
        private $db;
        private $valores;

        function __construct(){
            $this->query = null;
            $this->db = null;
            $this->valores = [];
        }

        function select($tabelas, $colunas){
            $this->query = "SELECT ".implode(", ", $colunas)." FROM ".implode(", ", $tabelas)." WHERE ";
            return $this;
        }

        function insert($tabela, $values){
            $this->query = "INSERT INTO {$tabela} VALUES ".itens($values).";";
            return $this;
        }

        function update($tabela){
            $this->query = "UPDATE {$tabela} SET ";
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

        function parametro($linha, $cond, $valor){
            $this->query .= "{$linha} {$cond} :{$linha}";
            $this->valores += [$linha => $valor];
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

        function construir(){
            $this->db = db_prepare($this->query);
            $this->db->execute($this->valores);
            return $this;
        }

        function construir_direto(){
            $this->db = db_prepare($this->query);
            $this->db->execute();
            return $this;
        }

        function array_num(){
            return $this->db->fetch(PDO::FETCH_NUM);
        }

        function array_assoc(){
            return $this->db->fetch(PDO::FETCH_ASSOC);
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

    }



