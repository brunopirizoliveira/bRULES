<?php

Class Categoria {

	private $cdcategoria;
	private $cdsistema;
	private $descricao;	
	
	public function getCdcategoria(){
		return $this->cdcategoria;
	}

	public function setCdcategoria($cdcategoria){
		$this->cdcategoria = $cdcategoria;
	}

	public function getCdsistema(){
		return $this->cdsistema;
	}

	public function setCdsistema($cdsistema){
		$this->cdsistema = $cdsistema;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

}