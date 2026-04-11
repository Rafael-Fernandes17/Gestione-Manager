<?php
$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao = $_POST["descricao"] ?? '';
    $tempoPreparo = $_POST["tempoPreparo"] ?? '';
    $preco = $_POST["preco"] ?? '';
    $quantidadeMedida = $_POST["quantidade"] ?? '';
    $tipoMedida = $_POST["tipoMedida"] ?? '';
    $statusProdutos = $_POST["statusProdutos"] ?? '';

    $preco = (int)str_replace(',', '.', $preco); 

    if (empty($nomeProdutoCardapio) || empty($descricao) || empty($tempoPreparo) ||
        $preco === '' || empty($quantidadeMedida) || empty($tipoMedida) || empty($statusProdutos)) {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    if (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== 0) {
        echo "Erro ao enviar imagem.";
        exit;
    }

    $imagem = file_get_contents($_FILES["imagem"]["tmp_name"]);

    $stmt = $conn->prepare("
        INSERT INTO produtosCardapio 
        (nomeProdutoCardapio, descricao, tempoPreparo, preco, imagem, quantidadeMedida, tipoMedida, statusProdutos)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die('Erro no prepare: ' . $conn->error);
    }

    $null = NULL;
    $stmt->bind_param("sssibiss",
        $nomeProdutoCardapio,
        $descricao,
        $tempoPreparo,
        $preco,
        $null,
        $quantidadeMedida,
        $tipoMedida,
        $statusProdutos
    );

    $stmt->send_long_data(4, $imagem);

    if ($stmt->execute()) {
        header("Location: readProdutoCardapio.php");
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>