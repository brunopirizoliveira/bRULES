<?php

Class Usuario {

	private $cdusuario;
	private $nmusuario;
	private $login;
	private $senha;
	private $master;

	
	public function getCdusuario(){
		return $this->cdusuario;
	}

	public function setCdusuario($cdusuario){
		$this->cdusuario = $cdusuario;
	}

	public function getNmusuario(){
		return $this->nmusuario;
	}

	public function setNmusuario($nmusuario){
		$this->nmusuario = $nmusuario;
	}

	public function getLogin(){
		return $this->login;
	}

	public function setLogin($login){
		$this->login = $login;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}	

	public function getMaster() {
		return $this->master;
	}

	public function setMaster($master) {
		$this->master = $master;
	}

}