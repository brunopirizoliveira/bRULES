<?php

require_once('../../model/inc.autoload.php');

$cdUsuario = $_REQUEST['cdUsuario'];

$usuarioDAO = new UsuarioDAO;

$user = $usuarioDAO->listaUsuarios($cdUsuario);

echo json_encode($user);