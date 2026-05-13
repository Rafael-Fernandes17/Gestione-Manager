<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function realizarLogin() {
    require_once 'conexao.php';

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $conexao->prepare(
        'SELECT * FROM funcionario WHERE email = ?'
    );
    
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $resultadoDaConsulta = $stmt->get_result();
    $funcionario = [];

    if ($resultadoDaConsulta->num_rows > 0) {
        $funcionarioDaTabela = $resultadoDaConsulta->fetch_assoc();
        $funcionario = $funcionarioDaTabela;

        if(password_verify($senha, $funcionario['senha'])){
            unset($funcionario['senha']);
            $_SESSION['usuario'] = $funcionario;
            return $funcionario;
        }
        return 'login nao realizado';

    } else {
        return 'login nao realizado';
    }

    $stmt->close();
    $conexao->close();
}


function verificaLogin(){
    $esperaJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;

    if (!isset($_SESSION['usuario'])) {
            $host = $_SERVER['HTTP_HOST']; 
            
            $pasta = '/Gestione-Manager'; 
            
            $url_login = "http://" . $host . $pasta . "/html/login.html";
            
            header("Location: $url_login");
            return;
    }

}

function verificaAdm(){
    verificaLogin();

    if ($_SESSION['usuario']['eAdm'] == 0) {
        $host = $_SERVER['HTTP_HOST']; 
            
            $pasta = '/Gestione-Manager'; 
            
            $url_login = "http://" . $host . $pasta . "/php/naoPode.php";
            
            header("Location: $url_login");
            return;
    exit;
    }
}