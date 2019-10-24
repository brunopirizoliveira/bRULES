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
            return 0;
        } else{
            $usuario = new Usuario;
            $usuario->setCdusuario($row['CDUSUARIO']);
            $usuario->setNmusuario($row['NMUSUARIO']);
            $usuario->setLogin($row['LOGIN']);
            $usuario->setSenha($row['SENHA']);

            return $usuario;
        }
		    
	}


	

}