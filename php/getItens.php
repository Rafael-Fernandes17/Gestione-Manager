<?php
<<<<<<< HEAD
include_once('verificaSessao.php');
include_once('conexao.php'); 

header('Content-Type: application/json');
=======
require_once 'verificaPermissao.php';
verificaLogin(); 
>>>>>>> main

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
<<<<<<< HEAD
$conexao->close();
?>
=======

// 3. Prepara variáveis para o formulário (dados vindos do Banco)
$idItem = htmlspecialchars($item['id']);
$nomeItemBD = htmlspecialchars($item['nomeItem']);
$categoriaBD = htmlspecialchars($item['categoria']);
$tipoMedidaBD = htmlspecialchars($item['tipoMedida']);
$quantidadeBD = htmlspecialchars($item['quantidadeUnitaria']);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
    <link rel="stylesheet" href="../css/editProdutosCardapio.css">
</head>
<body>
<header>
        <a href="logout.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>

        <nav>
            <a href="../indexFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="../view/cadastroItens.php">ESTOQUE</a>
            <a href="../view/criandoProdutoCardapio.php">PRODUTOS</a>
            <a href="aindaNao.php">FINANCEIRO</a>
            <a href="aindaNao.php">RELATÓRIOS</a>
            <a href="../view/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
        </nav>
    </header>

<div class="container">
    <div class="form-card">
        <h2>Editar Item</h2>

        <form method="POST">
            <label>ID:</label>
            <input type="text" value="<?= $idItem ?>" disabled>

            <label>Nome:</label>
            <input type="text" name="nomeItem" value="<?= $nomeItemBD ?>" required>

            <label>Categoria:</label>
            <select name="categoria">
                <option value="ingredientes" <?= $categoriaBD == 'ingredientes' ? 'selected' : '' ?>>Ingredientes</option>
                <option value="bebidas" <?= $categoriaBD == 'bebidas' ? 'selected' : '' ?>>Bebidas</option>
            </select>

            <label>Quantidade:</label>
            <input type="number" step="0.01" name="quantidadeEstoque" value="<?= $quantidadeBD ?>" required>

            <label>Tipo:</label>
            <select name="tipoMedida">
                <option value="GM" <?= $tipoMedidaBD == 'GM' ? 'selected' : '' ?>>GM</option>
                <option value="ML" <?= $tipoMedidaBD == 'ML' ? 'selected' : '' ?>>ML</option>
                <option value="L" <?= $tipoMedidaBD == 'L' ? 'selected' : '' ?>>L</option>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </div>
</div>
</body>
</html>
>>>>>>> main
