<?php

require_once('../../model/inc.autoload.php');

$idregra = $_REQUEST['idregra'];

$regraDAO = new RegraDAO;
$result = $regraDAO->listaRegra($idregra);

echo json_encode($result);