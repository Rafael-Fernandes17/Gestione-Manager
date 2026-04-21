<?php
$soVerificaAdm = true;

require_once 'verificaAdm.php';
include_once('conexao.php');

header('Content-Type: application/json; charset=utf-8');

    $retorno = [
        'status' => '',
        'mensagem' => '',
        'data' => []
    ];

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$eAdm = isset($_POST['eAdm']) ? 1 : 0;
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

if (empty($nome) || empty($email) || empty($senha_hash)) {
    $retorno = [
        'status' => 'nok', 
        'mensagem' => 'Preencha todos os campos'
        ];
    echo json_encode($retorno);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorno = [
        'status' => 'nok', 
        'mensagem' => 'email invalido'
        ];
    echo json_encode($retorno);
    exit;
}


// Verifica se já existe
$checandoEmail = $conexao->prepare('SELECT * FROM funcionario WHERE email = ?');
$checandoEmail->bind_param("s", $email);
$checandoEmail->execute();
$resultadoDaConsulta = $checandoEmail->get_result();

if ($resultadoDaConsulta->num_rows > 0) {
        $retorno = [ 
            'status' => 'nok',
            'mensagem' => 'email repetido',
            'data' => []
            ];
        echo json_encode($retorno);
        $checandoEmail->close();
        exit;
} else {
    $checandoEmail->close();

    // Inserir usuário
    $stmt = $conexao->prepare("INSERT INTO funcionario (nome, email, senha, eAdm) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $email, $senha_hash, $eAdm);

    if ($stmt->execute()) {
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'cadastro bem sucedido'
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'cadastro nao efetuado'
        ];
    }
    $stmt->close();
}

$conexao->close();
echo json_encode($retorno);

?>