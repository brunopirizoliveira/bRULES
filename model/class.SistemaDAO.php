<?php

require_once('info_conexao.php');

Class SistemaDAO {
	
	private $conn;

	public function SistemaDAO() {
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	}

	public function verificaExistencia($sistema) {

		$conn = $this->conn;
		
		$query = "SELECT COUNT(*) NUM, CDSISTEMA FROM SISTEMA WHERE DESCRICAO = '$sistema' ";

		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		if($row['NUM'] == 0) 
			return SistemaDAO::insereSistema($sistema);
		else
			return $row['CDSISTEMA'];
	}


	public function insereSistema($sistema) {

		$conn = $this->conn;
		
		$query =  "INSERT INTO SISTEMA(DESCRICAO) VALUES('$sistema')";
		$lastId = "SELECT LAST_INSERT_ID() AS CDSISTEMA FROM SISTEMA";
		
		if(mysqli_query($conn, $query)) {			
			$result = mysqli_query($conn, $lastId);
			$row = mysqli_fetch_assoc($result);
			
			return $row['CDSISTEMA'];
		} else {
			return 0;
		}

	}

	public function listSistemas() {

		$conn = $this->conn;

		$query = "SELECT CDSISTEMA, DESCRICAO FROM SISTEMA ";

		$result = mysqli_query($conn, $query);

		$vet = array();
		
		while( $row = mysqli_fetch_assoc($result) ) {			
			$sistema = new stdClass();
			
			$sistema->index = $row['CDSISTEMA'];
			$sistema->value = $row['DESCRICAO'];
			
			array_push($vet, $sistema);
			
		}
		return $vet;		
	}	

}