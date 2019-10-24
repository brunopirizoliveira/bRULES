<?php

require_once('info_conexao.php');

Class RegraDAO {
	
	private $conn;

	public function RegraDAO() {
		
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	}

	public function listaRegra() {

		$conn = $this->conn;

		$query = "
			SELECT REGRANEGOCIO.CDREGRA, 
			       REGRANEGOCIO.DESCRICAO AS REGRA,        
			       CATEGORIA.DESCRICAO AS CATEGORIA,       
			       SISTEMA.DESCRICAO AS SISTEMA,       
			       USUARIO.NMUSUARIO AS USUARIO
			FROM REGRANEGOCIO
			inner join CATEGORIA
			      on REGRANEGOCIO.cdcategoria = CATEGORIA.cdcategoria       
			inner join SISTEMA
			      on CATEGORIA.CDSISTEMA = SISTEMA.CDSISTEMA      
			inner join USUARIO
			      on REGRANEGOCIO.CDUSUARIO = USUARIO.CDUSUARIO";

		$result = mysqli_query($conn, $query);

		$vet = array();
		$i = 0;
		while( $row = mysqli_fetch_assoc($result) ) {			
			$regra = new stdClass();
			$regra->cdRegra 	= $row['CDREGRA'];
			$regra->categoria 	= $row['CATEGORIA'];
			$regra->sistema 	= $row['SISTEMA'];
			$regra->usuario 	= $row['USUARIO'];
			$regra->regra 		= $row['REGRA'];
			
			$vet[$i] = $regra;
			$i++;
		}
		return $vet;
	}

	public function insereRegra($cdCategoria, $cdUsuario, $regra) {

		$conn = $this->conn;
		
		$query = "INSERT INTO REGRANEGOCIO (CDCATEGORIA, CDUSUARIO, DESCRICAO) 
				  VALUES ($cdCategoria, $cdUsuario, '$regra') ";
		
		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}

	}


}