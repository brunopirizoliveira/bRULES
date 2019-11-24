<?php

require_once('../../model/inc.autoload.php');
	
$regra 		 = $_REQUEST['regra'];

$cdUsuario	 = $_COOKIE['CDUSUARIO'];

$sistemaDAO   = new SistemaDAO;
$categoriaDAO = new CategoriaDAO;
$regraDAO 	  = new RegraDAO;

$cdSistema   = $sistemaDAO->verificaExistencia($_REQUEST['sistema']);
$cdCategoria = $categoriaDAO->verificaExistencia($_REQUEST['categoria'], $cdSistema);

if( (isset($_REQUEST['idregra'])) && ($_REQUEST['idregra'] != "") ) {		
	$result = $regraDAO->editaRegra($cdCategoria, $cdUsuario, $regra, $_REQUEST['idregra']);
} else {	
	$result = $regraDAO->insereRegra($cdCategoria, $cdUsuario, $regra);
}


echo json_encode($result);