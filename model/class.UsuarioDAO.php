<?php

require_once('inc.autoload.php');
require_once('info_conexao.php');

Class UsuarioDAO {
	
	private $conn;

	public function UsuarioDAO() {
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    }
    
	public function listaUsuarios($cdusuario=false) {

		$conn = $this->conn;

		$query = "SELECT CDUSUARIO, NMUSUARIO, LOGIN, MASTER FROM USUARIO ";
		
		if($cdusuario) 
			$query.= " WHERE CDUSUARIO = ".$cdusuario;
		

		$result = mysqli_query($conn, $query);

		$vet = array();
		$i = 0;
		while( $row = mysqli_fetch_assoc($result) ) {			
			$usuario = new stdClass();
			$usuario->cdUsuario = $row['CDUSUARIO'];
			$usuario->nmUsuario = $row['NMUSUARIO'];
			$usuario->login 	= $row['LOGIN'];
			$usuario->master 	= $row['MASTER'];
			
			$vet[$i] = $usuario;
			$i++;
		}
		return $vet;
	}    

	public function verificaExistencia($usuario) {

		$conn = $this->conn;
		
        $query = "SELECT * FROM USUARIO WHERE login = '".$usuario->getLogin()."' and senha = '".$usuario->getSenha()."' ";
        
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

        if(!$row) {
            return null;
        } else{
            $usuario = new Usuario;
            $usuario->setCdusuario($row['CDUSUARIO']);
            $usuario->setNmusuario($row['NMUSUARIO']);
            $usuario->setLogin($row['LOGIN']);
            $usuario->setSenha($row['SENHA']);
            $usuario->setMaster($row['MASTER']);

            return $usuario;
        }
		    
	}

	public function salvaUsuario($login, $nome, $senha, $master, $idUsuario=false) {

		$conn = $this->conn;

		if($idUsuario)
			UsuarioDAO::editaUsuario($login, $nome, $senha, $master, $idUsuario);
		else
			UsuarioDAO::insereUsuario($login, $nome, $senha, $master);
	}
	
	public function editaUsuario($login, $nome, $senha, $master, $idUsuario) {

		$conn = $this->conn;



		$query = "UPDATE USUARIO 
				  SET LOGIN     = '".$login."',
					  NMUSUARIO = '".$nome."',					  
					  MASTER    = '".$master."'";

				if($senha != "********")
					$query.= ", SENHA = '".$senha."' ";

				$query.= "WHERE CDUSUARIO = ".$idUsuario;

		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}

	}

	public function insereUsuario($login, $nome, $senha, $master) {

		$conn = $this->conn;

		$query = "INSERT INTO USUARIO (LOGIN, NMUSUARIO, SENHA, MASTER) 
  			      VALUES('".$login."', '".$nome."', '".$senha."', '".$master."')";

		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}

	}

	public function removeUsuario($cdUsuario) {

		$conn = $this->conn;
		
		$query = "DELETE FROM USUARIO WHERE CDUSUARIO = ".$cdUsuario;
		
		if(mysqli_query($conn, $query)) {
			return true;
		} else {
			return false;
		}

	}	

}