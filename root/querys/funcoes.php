<?php
    function db_main(){
		$CONECTAR = new PDO('mysql:host=' . DB_MAIN . ';dbname=' . DB_MAIN_NAME . ';charset=utf8', DB_MAIN_USR, DB_MAIN_PASS);
  
		return $CONECTAR;
	}

    function insert_values($array){
        ## $str[0] => ["1", "2", "3"] => "(1, 2, 3)" 
	    ## $str[1] => ["1", "2", "3"] => "(:1, :2, :3)"
        $str = ["(", "("];    

		foreach($array as $key => $val){
			$str[0] = $str[0]."$key, ";
			$str[1] = $str[1].":$key, ";
		}
		
		$str[0] = substr_replace($str[0], ")", -2);
		$str[1] = substr_replace($str[1], ")", -2);

	    return $str;
    }

    ## ['id', 'usuario', 'nome', 'senha'] => "id = :id, usuario = :usuario, nome = :nome, senha = :senha"
	function update_values($valores){
		$str = "";

		foreach ($valores as $key => $value){
			$str = $str."$key = :$key, ";
		}

		$str = substr_replace($str, "", -2);
		return $str;
	}


    function db_prepare($query){
        $DB = db_main();
        $exec = $DB->prepare($query);
        return $exec;
    }