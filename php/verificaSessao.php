<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    // Verifica se a requisição veio do seu JavaScript (Fetch) pedindo JSON
    $wantsJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;

    if ($wantsJson) {
        // Cenário 2: É o JavaScript pedindo! Mandamos o JSON para ele não quebrar.
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'erro', 'mensagem' => 'sessao_invalida']);
        exit; 
    } else {
        // Cenário 1: É o usuário tentando acessar a página direto na URL. Redirecionamos!
        header("Location: ../html/login.html"); // (Ajuste o caminho se precisar)
        exit;
    }
}
?>