<?php

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("<h3>ID do produto não fornecido.</h3>");
}

$id = $_GET["id"];

if (!is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}


$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

$sql = "DELETE FROM produtosCardapio WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('Erro no prepare: ' . $conn->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redireciona de volta para a página de leitura com uma mensagem de sucesso
    header("Location: readProdutoCardapio.php?status=deleted_success");
    exit;
} else {
    // Redireciona de volta para a página de leitura com uma mensagem de erro
    header("Location: readProdutoCardapio.php?status=deleted_error");
    exit;
}


$stmt->close();
$conn->close();

?>