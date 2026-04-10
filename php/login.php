<?php // php/cliente_login.php
    include_once('conexao.php');

    $retorno = [
        'status' => '', 
        'mensagem' => '', 
        'data' => []
        ];

    $stmt = $conexao->prepare(
        'SELECT * FROM cliente WHERE email = ?'
    );

    
$stmt->bind_param('ss', $_POST['email']);
$stmt->execute();

$resultadoDoConsulta = $stmt->get_result();
$usuario = [];

if ($resultadoDaConsulta->num_rows() > 0) {
    while ($funcionarioDaTabela = $resultadoDaConsulta->fetch_assoc()) {
        $funcionario[] = $funcionarioDaTabela;
    }

    $hashDaSenha = $funcionario['senha'];

    if(!password_verify($_POST['senha'], $hashDaSenha)){
        $retorno['status'] = 'nok';
        $retorno['mensagem'] = 'senha invalida';
    }
    

// Criar a sessão com os dados do usuário logado
session_start();
    $_SESSION['usuario'] = $funcionario;

    $retorno['status'] = 'ok';
    $retorno['mensagem'] = 'Login efetuado com sucesso';
    $retorno['data'] = $funcionario;
} else {
    $retorno['status'] = 'nok';
    $retorno['mensagem'] = 'Email ou senha invalidos.';
}



$stmt->close();
$conexao->close();
header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);
