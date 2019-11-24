<?php

require_once('info_conexao.php');

Class CategoriaDAO {
	
	private $conn;

	public function CategoriaDAO() {
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	}

	public function verificaExistencia($categoria, $cdSistema) {

		$conn = $this->conn;
		
		$query = "SELECT COUNT(*) NUM, CDCATEGORIA 
				  FROM CATEGORIA 
				  WHERE DESCRICAO = '$categoria' 
				  AND CDSISTEMA = ".$cdSistema;

		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		if($row['NUM'] == 0) 
			return CategoriaDAO::insereCategoria($categoria, $cdSistema);
		else
			return $row['CDCATEGORIA'];
	}


	public function insereCategoria($categoria, $cdSistema) {

		$conn = $this->conn;
		
		$query =  "INSERT INTO CATEGORIA(DESCRICAO, CDSISTEMA) VALUES('$categoria', $cdSistema);";
		$lastId = "SELECT LAST_INSERT_ID() as CDCATEGORIA FROM CATEGORIA";
		
		if( mysqli_query($conn, $query) ) {
			$result = mysqli_query($conn, $lastId);
			$row = mysqli_fetch_assoc($result);	
			
			return $row['CDCATEGORIA'];
		} else {
			return 0;
		}
		
	}

	public function listCategorias() {

		$conn = $this->conn;

		$query = "SELECT CDCATEGORIA, DESCRICAO, CDSISTEMA FROM CATEGORIA ";

		$result = mysqli_query($conn, $query);

		$vet = array();
		
		while( $row = mysqli_fetch_assoc($result) ) {			
			$categoria = new stdClass();
			
			$categoria->index = $row['CDCATEGORIA'];
			// $categoria->cdsistema 	= $row['CDSISTEMA'];
			$categoria->value = $row['DESCRICAO'];
			
			array_push($vet, $categoria);
			
		}
		return $vet;		
	}

}