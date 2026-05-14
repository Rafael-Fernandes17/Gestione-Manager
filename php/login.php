<?php
ini_set('display_errors', 0);
error_reporting(0);

require_once '../php/verificaPermissao.php';

header('Content-Type: application/json');

$resultadoLogin = realizarLogin();

if ($resultadoLogin === 'login nao realizado') {
    echo json_encode(['status' => 'nok']);
} elseif ($resultadoLogin === 'primeiro_acesso') {
    echo json_encode(['status' => 'primeiro_acesso']);
} elseif (is_array($resultadoLogin)) {
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'message' => $resultadoLogin]);
}
?>