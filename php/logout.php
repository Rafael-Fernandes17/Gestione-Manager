<?php
require_once 'verifyPermissao.php'; 
verificaLogin();

// 1. Limpa todas as variáveis da memória
$_SESSION = array();

// 2. Mata o cookie de sessão no navegador do usuário
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destrói a sessão no servidor
session_unset();
session_destroy();

// 4. Redireciona
header("Location: ../html/login.html");
//
exit;