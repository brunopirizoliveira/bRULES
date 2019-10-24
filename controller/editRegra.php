<?php

	require_once('../model/inc.autoload.php');
	require_once("../model/info_conexao.php");

	$tpl = new TemplatePower('../view/_MASTER.html');							 

	$tpl->assignInclude('content', '../view/editRegra.html');
	$tpl->assignInclude('menu', '../view/menu.html');	

	$tpl->prepare();
	
	$tpl->printToScreen();