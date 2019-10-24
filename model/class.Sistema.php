<?php

Class Sistema {
	
	private $cdsistema;
	private $descricao;

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