<?php

	require_once('../model/inc.autoload.php');
	require_once("../model/info_conexao.php");

	$tpl = new TemplatePower('../view/_MASTER.html');							 

	$tpl->assignInclude('content', '../view/admin.html');
	$tpl->assignInclude('menu', '../view/menu.html');	

	$tpl->prepare();
	
	$usuarioDAO = new UsuarioDAO();
	$list_usuarios = $usuarioDAO->listaUsuarios();

	foreach ($list_usuarios as $usuario) {
		$tpl->newBlock('list_usuarios');
		
		$tpl->assign('cdusuario', $usuario->cdUsuario);
		$tpl->assign('nome', $usuario->nmUsuario);
		$tpl->assign('login', $usuario->login);
	}

	$tpl->printToScreen();