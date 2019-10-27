<?php

require_once('../../model/inc.autoload.php');

$categoriaDAO = new CategoriaDAO;
$result = $categoriaDAO->listCategorias();

echo json_encode($result);