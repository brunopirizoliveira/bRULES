<?php

require_once('../../model/inc.autoload.php');

$cdusuario 	  = $_REQUEST['cdusuario'];
$usuarioDAO	  = new UsuarioDAO;
$result       = $usuarioDAO->removeUsuario($cdusuario);

echo json_encode($result);