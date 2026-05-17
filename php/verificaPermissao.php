<?php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function realizarLogin() {
    global $conexao;

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    try {

        $stmt = $conexao->prepare(
            "SELECT id, nome, email, senha, eAdm, primeiroAcesso 
             FROM funcionario 
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $funcionario = $resultado->fetch_assoc();

        if ($funcionario) {
            if (password_verify($senha, $funcionario['senha'])) {

                unset($funcionario['senha']);

                $_SESSION['usuario'] = $funcionario;

                if (isset($funcionario['primeiroAcesso']) &&$funcionario['primeiroAcesso'] == 1 ){
                    return 'primeiro_acesso';
                }
                return $funcionario;
            }
            return 'login nao realizado';
        } else {
            return 'login nao realizado';
        }
    } catch (Exception $e) {
        return 'Erro no banco de dados: ' . $e->getMessage();
    }
}

function verificaLogin() {
    if (!isset($_SESSION['usuario'])) {
        $host = $_SERVER['HTTP_HOST'];
        $pasta = '/Gestione-Manager';
        $url_login = "http://" . $host . $pasta . "/html/login.html";
        header("Location: $url_login");
        exit;
    }

    if (isset($_SESSION['usuario']['primeiroAcesso']) && $_SESSION['usuario']['primeiroAcesso'] == 1) {
        $host = $_SERVER['HTTP_HOST'];
        $pasta = '/Gestione-Manager';
        $url_alterar_senha = "http://" . $host . $pasta . "/html/alterar_senha.html";
        header("Location: $url_alterar_senha");
        exit;
    }
}

function verificaAdm() {
    verificaLogin();

    if (isset($_SESSION['usuario']['eAdm']) && $_SESSION['usuario']['eAdm'] == 0) {
        $host = $_SERVER['HTTP_HOST'];
        $pasta = '/Gestione-Manager';
        $url_nao_pode = "http://" . $host . $pasta . "/php/naoPode.php";
        header("Location: $url_nao_pode");
        exit;
    }
}
?>