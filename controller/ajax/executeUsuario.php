<?php

require_once('../../model/inc.autoload.php');

$usuarioDAO   = new UsuarioDAO;
$result = $usuarioDAO->salvaUsuario($_REQUEST['loginUsuario'], $_REQUEST['nmUsuario'], $_REQUEST['senhaUsuario'], $_REQUEST['idUsuario']);


echo json_encode($result);