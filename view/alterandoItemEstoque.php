<?php
require_once '../php/verificaPermissao.php';
verificaLogin(); 
include_once('conexao.php');

$id = $_GET['id'] ?? null;

<<<<<<< HEAD
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Content-Type: application/json');
    try {
        $stmt = $conexao->prepare("SELECT * FROM itensEstoque WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'dados' => $item]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'mensagem' => $e->getMessage()]);
=======
if (!$id || !is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM itensestoque WHERE idItensEstoque = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<h3>Item não encontrado.</h3>");
}

$item = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeItemPost = $_POST["nomeItem"] ?? '';
    $categoriaPost = $_POST["categoria"] ?? '';
    $tipoMedidaPost = $_POST["tipoMedida"] ?? '';
    $quantidadePost = $_POST["quantidadeEstoque"] ?? '';

    if (empty($nomeItemPost) || empty($categoriaPost) || empty($tipoMedidaPost) || empty($quantidadePost)) {
        echo "<h3 style='text-align:center;color:red;'>Preencha todos os campos!</h3>";
    } else {
        $sql_update = "UPDATE itensestoque SET 
            nomeItem=?,
            tipoMedida=?,
            categoria=?,
            quantidadeUnitaria=? 
            WHERE idItensEstoque=?";

        $stmt_update = $conn->prepare($sql_update);

        if (!$stmt_update) {
            die("Erro no prepare: " . $conn->error);
        }

        $stmt_update->bind_param(
            "sssdi", 
            $nomeItemPost,
            $tipoMedidaPost,
            $categoriaPost,
            $quantidadePost,
            $id
        );

        if ($stmt_update->execute()) {
            header("Location: readItens.php?status=success");
            exit;
        } else {
            echo "Erro ao atualizar: " . $stmt_update->error;
        }
        $stmt_update->close();
>>>>>>> 2cd921ff9c87c95fd64f22f86014260427eda96d
    }
    exit;
}
<<<<<<< HEAD
?>
=======

// 3. Prepara variáveis para o formulário (dados vindos do Banco)
$idItem = htmlspecialchars($item['idItensEstoque']);
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
            <a href="paginaPrincipalFuncionario.php">HOME</a>
            <a href="../php/aindaNao.php">DASHBOARD</a>
            <a href="../php/aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="../php/aindaNao.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
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
                <option value="UN" <?= $tipoMedidaBD == 'UN'? 'selected' : '' ?>>UN</option>
                <option value="KG" <?= $tipoMedidaBD == 'KG'? 'selected' : '' ?>>KG</option>
                <option value="G" <?= $tipoMedidaBD == 'G'? 'selected' : '' ?>>G</option>
                <option value="MG" <?= $tipoMedidaBD == 'GM' ? 'selected' : '' ?>>GM</option>
                <option value="ML" <?= $tipoMedidaBD == 'ML' ? 'selected' : '' ?>>ML</option>
                <option value="L" <?= $tipoMedidaBD == 'L' ? 'selected' : '' ?>>L</option>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </div>
</div>
</body>
</html>
>>>>>>> 2cd921ff9c87c95fd64f22f86014260427eda96d
