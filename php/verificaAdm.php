<?php
// 1. Chama o porteiro primeiro. Se não tiver sessão, o PHP morre lá dentro e redireciona.
require_once 'verificaSessao.php'; 

$usuario = $_SESSION['usuario'];
$eAdm = isset($usuario['eAdm']) ? (int)$usuario['eAdm'] : 0;
$isFetch = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

if ($eAdm !== 1) {
    if ($isFetch) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'nok', 'mensagem' => 'sem_permissao']);
        exit;
    }
    return;
}

if ($isFetch) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'eAdm' => 'ok']);
    exit;
}