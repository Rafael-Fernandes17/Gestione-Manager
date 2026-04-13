<?php
    session_start();
    
    include_once('conexao.php');

    header('Content-type: application/json; charset=utf-8');
    $retorno = [
        'status' => 'nok', 
        'mensagem' => 'credenciais invalidas', 
        'data' => []
        ];

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
        // Criar a sessão com os dados do usuário logado
        unset($funcionario['senha']);
        $_SESSION['usuario'] = $funcionario;
        error_log("Dados gravados na sessão: " . print_r($_SESSION['usuario'], true));

        $retorno['status'] = 'ok';
        $retorno['mensagem'] = 'login efetuado com sucesso';
        $retorno['data'] = $funcionario;
    }
} else {
    $retorno['status'] = 'nok';
    $retorno['mensagem'] = 'credenciais invalidas';
}

$stmt->close();
$conexao->close();
echo json_encode($retorno);
