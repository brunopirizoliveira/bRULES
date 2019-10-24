<?php

require_once('../../model/inc.autoload.php');

$usuario = new Usuario;
$usuario->setLogin($_REQUEST['login']);
$usuario->setSenha($_REQUEST['senha']);

$usuarioDAO = new UsuarioDAO;
$retornoUsuario = $usuarioDAO->verificaExistencia($usuario);

if($retornoUsuario == 0) {
    echo json_encode($retornoUsuario);
} else {
    
    setcookie('CDUSUARIO', $retornoUsuario->getCdusuario(), time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie('LOGIN',     $retornoUsuario->getLogin(), time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie('NMUSUARIO', $retornoUsuario->getSenha(), time() + (86400 * 30), "/"); // 86400 = 1 day

    echo json_encode(1);
}
