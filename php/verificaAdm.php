<?php
include_once('verificaSessao.php');


$eAdm = isset($_SESSION['usuario']['eAdm']) ? (int)$_SESSION['usuario']['eAdm'] : 0;

if ($eAdm === 1) {
    return; 
} else {
    $isJson = (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    if ($isJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'nok', 'eAdm' => 'nok']);
        exit;
    } else {
        echo json_encode(['status' => 'nok', 'eAdm' => 'nok']);
        exit;
    }
}