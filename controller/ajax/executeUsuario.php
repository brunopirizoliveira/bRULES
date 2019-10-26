<?php

require_once('../../model/inc.autoload.php');

$cdUsuario   = $_REQUEST['idUsuario'];

$usuarioDAO   = new UsuarioDAO;
$usuarioDAO->salvaUsuario($_REQUEST['loginUsuario'], $_REQUEST['nmUsuario'], $_REQUEST['senhaUsuario'], $_REQUEST['idUsuario']);


//echo json_encode($result);