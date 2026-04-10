<?php
    include_once('conexao.php');

    $retorno = [
        'status' => '',
        'mensagem' => '',
        'data' => []
    ];

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($nome) || empty($email) || empty($senha)) {
    die("Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Verifica se já existe
$checandoEmail = $conexao->prepare('SELECT * FROM funcionario WHERE email = ?');
$checandoEmail->bind_param("s", $email);
$checandoEmail->execute();
$resultadoDaConsulta = $checandoEmail->get_result();

if ($resultadoDaConsulta->num_rows > 0) {
    die("E-mail já cadastrado.");
    $checandoEmail->close();
} else {
    $checandoEmail->close();

    // Inserir usuário
    $stmt = $conexao->prepare("INSERT INTO funcionario (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

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
}


$stmt->close();
$conexao->close();
header('Content-type: application/json; charset=utf-8');
echo json_encode($retorno);

?>