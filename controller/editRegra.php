<?php

	require_once('../model/inc.autoload.php');
	require_once("../model/info_conexao.php");

	$tpl = new TemplatePower('../view/_MASTER.html');							 

	$tpl->assignInclude('content', '../view/editRegra.html');
	$tpl->assignInclude('menu', '../view/menu.html');	

	$tpl->prepare();

	$tpl->newBlock('list_regra');

	if(isset($_REQUEST['cdregra'])) {

		$regraDAO = new RegraDAO;
		$regra = $regraDAO->listaRegra($_REQUEST['cdregra']);
		if($regra[0]) {

			$tpl->assign('cdregra',   $regra[0]->cdRegra);
			$tpl->assign('sistema',   $regra[0]->sistema);
			$tpl->assign('categoria', $regra[0]->categoria);
			$tpl->assign('usuario',   $regra[0]->usuario);
			$tpl->assign('regra',     $regra[0]->regra);

		}

	}

	
	$tpl->printToScreen();