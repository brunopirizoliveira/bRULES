<?php

	require_once('../model/inc.autoload.php');
	require_once("../model/info_conexao.php");
	// $conn = ibase_connect (DBTNS, DBUSER, DBPASS, 'UTF8', '0', '1') ;

	$tpl = new TemplatePower('../view/_MASTER.html');							 

	$tpl->assignInclude('content', '../view/listaRegras.html');
	$tpl->assignInclude('menu', '../view/menu.html');	

	$tpl->prepare();

	$regraDAO = new RegraDAO();
	
	if((isset($_REQUEST['busca'])) && ($_REQUEST['busca'] != "")) {
		$list_regras = $regraDAO->listaRegra(null, $_REQUEST['busca']);
	} else {
		$list_regras = $regraDAO->listaRegra();		
	}
	
	
	if(count($list_regras) > 0) {
		
		$tpl->newBlock('tbl_regra');
		foreach ($list_regras as $regra) {
			$tpl->newBlock('list_regra');
			
			$tpl->assign('cdregra', $regra->cdRegra);
			$tpl->assign('sistema', $regra->sistema);
			$tpl->assign('categoria', $regra->categoria);
			$tpl->assign('usuario', $regra->usuario);
			$tpl->assign('regra', $regra->regra);
		}

	}

	
	$tpl->printToScreen();