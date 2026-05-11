<?php
include_once('verificaSessao.php');
include_once('conexao.php'); 

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo json_encode(['status' => 'error', 'mensagem' => 'ID inválido']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $stmt = $conexao->prepare("SELECT * FROM itensestoque WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item) {
        echo json_encode(['status' => 'success', 'dados' => $item]);
    } else {
        echo json_encode(['status' => 'error', 'mensagem' => 'Item não encontrado']);
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeItem = $_POST["nomeItem"] ?? '';
    $categoria = $_POST["categoria"] ?? '';
    $tipoMedida = $_POST["tipoMedida"] ?? '';
    $quantidade = $_POST["quantidadeEstoque"] ?? '';

    if (empty($nomeItem) || empty($categoria) || empty($tipoMedida) || empty($quantidade)) {
        echo json_encode(['status' => 'error', 'mensagem' => 'Preencha todos os campos']);
        exit;
    }

    $sql = "UPDATE itensestoque SET nomeItem=?, tipoMedida=?, categoria=?, quantidadeUnitaria=? WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssdi", $nomeItem, $tipoMedida, $categoria, $quantidade, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'mensagem' => 'Item atualizado com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao atualizar: ' . $conexao->error]);
    }
    $stmt->close();
}
$conexao->close();
?>