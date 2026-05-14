<?php
require_once 'verificaPermissao.php'; 
verificaLogin(); 

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    echo json_encode(['status' => 'nok', 'mensagem' => 'Erro na conexão: ' . mysqli_connect_error()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao = $_POST["descricao"] ?? '';
    $categoria = $_POST["categoria"] ?? '';
    $tempoPreparo = $_POST["tempoPreparo"] ?? '';
    $preco = $_POST["preco"] ?? '';
    $quantidadeMedida = $_POST["quantidade"] ?? '';
    $tipoMedida = $_POST["tipoMedida"] ?? '';
    $statusProdutos = $_POST["statusProdutos"] ?? '';

    $preco = (float) str_replace(',', '.', $preco);

    // Validação de campos vazios
    if (
        empty($nomeProdutoCardapio) ||
        empty($descricao) ||
        empty($categoria) ||
        empty($tempoPreparo) ||
        empty($quantidadeMedida) ||
        empty($tipoMedida) ||
        empty($statusProdutos)
    ) {
        // 2. Avisa o erro e PARA a execução com o exit
        echo json_encode(['status' => 'nok', 'mensagem' => 'preencha todos os campos']);
        exit; 
    }

    // Validação de imagem
    if (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== 0) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'erro ao enviar imagem']);
        exit;
    }

    $imagem = file_get_contents($_FILES["imagem"]["tmp_name"]);

    if ($imagem === false) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'erro ao ler imagem']);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO produtosCardapio 
        (nomeProdutoCardapio, descricao, categoria, tempoPreparo, preco, imagem, quantidadeMedida, tipoMedida, statusProdutos)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        echo json_encode(['status' => 'nok', 'mensagem' => 'erro no prepare']);
        exit;
    }

    $stmt->bind_param("ssssdsiss",
        $nomeProdutoCardapio,
        $descricao,
        $categoria,
        $tempoPreparo,
        $preco,
        $imagem,
        $quantidadeMedida,
        $tipoMedida,
        $statusProdutos
    );

    // 3. Devolvemos JSON de SUCESSO ao invés de redirecionar!
    if ($stmt->execute()) {
        $retorno = [
            'status' => 'ok',
            'mensagem' => 'Produto cadastrado com sucesso!'
        ];
    } else {
        $retorno = [
            'status' => 'nok',
            'mensagem' => 'erro ao cadastrar produto'
        ];
    }

    $stmt->close();
    
    echo json_encode($retorno);
}
$conn->close();
?>