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
            'SELECT id, nome, email, senha, eAdm, primeiroAcesso FROM funcionario WHERE email = :email'
        );
        
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($funcionario) {
            if (password_verify($senha, $funcionario['senha'])) {
                unset($funcionario['senha']);
                $_SESSION['usuario'] = $funcionario;
                
                if (isset($funcionario['primeiroAcesso']) && $funcionario['primeiroAcesso'] == 1) {
                    return 'primeiro_acesso';
                }
                return $funcionario;
            }
            return 'login nao realizado';
        } else {
            return 'login nao realizado';
        }
    } catch (PDOException $e) {
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