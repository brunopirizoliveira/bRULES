<?php

require_once('inc.autoload.php');
require_once('info_conexao.php');

Class UsuarioDAO {
	
	private $conn;

	public function UsuarioDAO() {
		$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    }
    
	public function listaUsuarios() {

		$conn = $this->conn;

		$query = "SELECT CDUSUARIO, NMUSUARIO, LOGIN FROM USUARIO ";

		$result = mysqli_query($conn, $query);

		$vet = array();
		$i = 0;
		while( $row = mysqli_fetch_assoc($result) ) {			
			$usuario = new stdClass();
			$usuario->cdUsuario = $row['CDUSUARIO'];
			$usuario->nmUsuario = $row['NMUSUARIO'];
			$usuario->login 	= $row['LOGIN'];
			
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

            return $usuario;
        }
		    
	}

	public function salvaUsuario($login, $nome, $senha, $idUsuario=null) {

		$conn = $this->conn;

		if($idUsuario)
			UsuarioDAO::editaUsuario($login, $nome, $senha, $idUsuario);
		else
			UsuarioDAO::insereUsuario($login, $nome, $senha);
	}
	
	public function editaUsuario($login, $nome, $senha, $idUsuario) {

		$conn = $this->conn;

		$query = "UPDATE USUARIO 
				  SET LOGIN     = '".$login."',
					  NMUSUARIO = '".$nome."',
					  SENHA     = '".$senha."'
				  WHERE CDUSUARIO = ".$idUsuario;

		$result = mysqli_query($conn, $query);

		return $result;

	}

	public function insereUsuario($login, $nome, $senha) {

		$conn = $this->conn;

		$query = "INSERT INTO USUARIO (LOGIN, NMUSUARIO, SENHA) 
  			      VALUES('".$login."', '".$nome."', '".$senha."')";

		$result = mysqli_query($conn, $query);

		return $result;

	}

}