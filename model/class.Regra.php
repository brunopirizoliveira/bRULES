<?php

Class Regra {
	
	private $cdregra;
	private $cdcategoria;
	private $cdusuario;
	private $descricao;

	public function getCdregra(){
		return $this->cdregra;
	}

	public function setCdregra($cdregra){
		$this->cdregra = $cdregra;
	}

	public function getCdcategoria(){
		return $this->cdcategoria;
	}

	public function setCdcategoria($cdcategoria){
		$this->cdcategoria = $cdcategoria;
	}

	public function getCdusuario(){
		return $this->cdusuario;
	}

	public function setCdusuario($cdusuario){
		$this->cdusuario = $cdusuario;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}	
}