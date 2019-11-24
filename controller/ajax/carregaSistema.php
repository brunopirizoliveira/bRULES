<?php

require_once('../../model/inc.autoload.php');

$sistemaDAO = new SistemaDAO;
$result = $sistemaDAO->listSistemas();

echo json_encode($result);