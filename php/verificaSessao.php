<?php
// verificaSessao.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$wantsJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;

if (!isset($_SESSION['usuario'])) {
    if ($wantsJson) {
        // Se o JS pediu, mandamos o erro em JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'nok', 'mensagem' => 'Sessão expirada']);
        exit;
    } else {
        $host = $_SERVER['HTTP_HOST']; 
        
        $pasta = '/Gestione-Manager'; 
        
        $url_login = "http://" . $host . $pasta . "/html/login.html";
        
        header("Location: $url_login");
        exit;
    }
}

if (isset($soVerifica) && $soVerifica === true) {
    return; // Apenas volta para o arquivo que chamou, sem dar echo nem exit
}

if ($wantsJson) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'ok', 'mensagem' => 'Sessão ativa']);
    exit;
} 

// Se NÃO for JSON (ou seja, é um include no topo da página), 
// o PHP não faz NENHUM echo. Ele apenas termina e deixa o HTML carregar.