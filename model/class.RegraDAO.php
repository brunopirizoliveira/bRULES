<?php

require_once('info_conexao.php');

Class RegraDAO {
	
	private $conn;

	public function RegraDAO() {
		
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	}

	public function listaRegra($cdRegra=null, $busca=null) {

		$conn = $this->conn;

		$query = "
			SELECT REGRANEGOCIO.CDREGRA, 
			       REGRANEGOCIO.DESCRICAO AS REGRA,   
			       CATEGORIA.CDCATEGORIA,     
			       CATEGORIA.DESCRICAO AS CATEGORIA,       
			       SISTEMA.CDSISTEMA,
			       SISTEMA.DESCRICAO AS SISTEMA,       
			       USUARIO.NMUSUARIO AS USUARIO
			FROM REGRANEGOCIO
			inner join CATEGORIA
			      on REGRANEGOCIO.cdcategoria = CATEGORIA.cdcategoria       
			inner join SISTEMA
			      on CATEGORIA.CDSISTEMA = SISTEMA.CDSISTEMA      
			inner join USUARIO
			      on REGRANEGOCIO.CDUSUARIO = USUARIO.CDUSUARIO";

		if($cdRegra){
			$query.= " WHERE REGRANEGOCIO.CDREGRA = ".$cdRegra;
		}
		else if($busca){
			$busca = strtoupper($busca);
			$query.= " WHERE UPPER(REGRANEGOCIO.DESCRICAO) LIKE '%".$busca."%' 
					   OR    UPPER(CATEGORIA.DESCRICAO) LIKE '%".$busca."%' 
					   OR    UPPER(SISTEMA.DESCRICAO) LIKE '%".$busca."%' ";
		}

		$result = mysqli_query($conn, $query);

		$vet = array();
		$i = 0;
		while( $row = mysqli_fetch_assoc($result) ) {			
			$regra = new stdClass();
			$regra->cdRegra 	= $row['CDREGRA'];
			$regra->cdsistema   = $row['CDSISTEMA'];
			$regra->cdcategoria = $row['CDCATEGORIA'];
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

	public function editaRegra($cdCategoria, $cdUsuario, $regra, $idRegra) {
		
		$conn = $this->conn;
		
		$query = "UPDATE REGRANEGOCIO SET CDCATEGORIA = $cdCategoria,
										  DESCRICAO = '$regra'
									  WHERE CDREGRA = ".$idRegra;
		
		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}		
	}

	public function removeRegra($cdRegra) {

		$conn = $this->conn;
		
		$query = "DELETE FROM REGRANEGOCIO WHERE CDREGRA = ".$cdRegra;
		
		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}

	}


}