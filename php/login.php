<?php // php/cliente_login.php
    include_once('conexao.php');

    header('Content-type: application/json; charset=utf-8');
    $retorno = [
        'status' => '', 
        'mensagem' => '', 
        'data' => []
        ];

    $stmt = $conexao->prepare(
        'SELECT * FROM funcionario WHERE email = ?'
    );
    
$stmt->bind_param('s', $_POST['email']);
$stmt->execute();

$resultadoDaConsulta = $stmt->get_result();
$funcionario = [];

if ($resultadoDaConsulta->num_rows > 0) {
    if($funcionarioDaTabela = $resultadoDaConsulta->fetch_assoc()) {
        $funcionario = $funcionarioDaTabela;
    }

    $hashDaSenha = $funcionario['senha'];

    if(!password_verify($_POST['senha'], $hashDaSenha)){
        $retorno['status'] = 'nok';
        $retorno['mensagem'] = 'senha invalida';
    } else {
        // Criar a sessão com os dados do usuário logado
        unset($funcionario['senha']);
        session_start();
        $_SESSION['usuario'] = $funcionario;

        $retorno['status'] = 'ok';
        $retorno['mensagem'] = 'Login efetuado com sucesso';
        $retorno['data'] = $funcionario;
    }
} else {
    $retorno['status'] = 'nok';
    $retorno['mensagem'] = 'Email invalido';
}


$stmt->close();
$conexao->close();
echo json_encode($retorno);
