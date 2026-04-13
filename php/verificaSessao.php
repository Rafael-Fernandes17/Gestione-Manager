<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    // Verificamos se a requisição é do JavaScript (AJAX/Fetch)
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    $wantsJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;

    if ($isAjax || $wantsJson) {
        // Se for JS, mandamos JSON e PARAMOS (exit)
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'nok', 'mensagem' => 'sessao_invalida']);
        exit; 
    } else {
        // Se for acesso direto pela barra de endereço, REDIRECIONAMOS
        header("Location: ../html/login.html");
        exit;
    }
}