<?php

require_once('../../model/inc.autoload.php');

$regra 		 = $_REQUEST['regra'];
$cdUsuario	 = 1;


$sistemaDAO   = new SistemaDAO;
$categoriaDAO = new CategoriaDAO;
$regraDAO 	  = new RegraDAO;

$cdSistema   = $sistemaDAO->verificaExistencia($_REQUEST['sistema']);
$cdCategoria = $categoriaDAO->verificaExistencia($_REQUEST['categoria'], $cdSistema);

if($_REQUEST['idRegra']) {
	// $regraDAO->editaRegra($cdCategoria, $cdUsuario, $regra, $_REQUEST['idRegra']);	
} else {
	$result = $regraDAO->insereRegra($cdCategoria, $cdUsuario, $regra);
}


echo json_encode($result);