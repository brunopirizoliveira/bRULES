<?php

require_once('../../model/inc.autoload.php');

$cdregra   = $_REQUEST['cdregra'];
$regraDAO  = new RegraDAO;
$result    = $regraDAO->removeRegra($cdregra);


echo json_encode($result);