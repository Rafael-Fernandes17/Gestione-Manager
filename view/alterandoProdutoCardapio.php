<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
include_once('../php/conexao.php');

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

$conn = mysqli_connect('localhost:3307', 'root', '', 'gestione_manager');

if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM produtosCardapio WHERE idProdutosCardapio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<h3>Produto não encontrado.</h3>");
}

$produto = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeProdutoCardapio = $_POST["nomeProdutoCardapio"] ?? '';
    $descricao           = $_POST["descricao"] ?? '';
    $categoria           = $_POST["categoria"] ?? '';
    $tempoPreparo        = $_POST["tempoPreparo"] ?? '';
    $tipoMedida          = $_POST["tipoMedida"] ?? '';
    $quantidade          = $_POST["quantidadeMedida"] ?? '';

    // Mantém preço e status do banco, não do POST
    $preco  = $produto['preco'];
    $status = $produto['statusProdutos'];

    $novaImagem = !empty($_FILES['imagem']['tmp_name'])
        ? file_get_contents($_FILES['imagem']['tmp_name'])
        : $produto['imagem'];

    if (empty($nomeProdutoCardapio) || empty($descricao) || empty($categoria) ||
        empty($tempoPreparo) || empty($tipoMedida) || empty($quantidade)) {
        echo "<h3 style='text-align:center;color:red;'>Preencha todos os campos!</h3>";
    } else {

        $sql_update = "UPDATE produtosCardapio SET 
            nomeProdutoCardapio = ?,
            descricao           = ?,
            categoria           = ?,
            tempoPreparo        = ?,
            tipoMedida          = ?,
            quantidadeMedida    = ?,
            imagem              = ?
            WHERE idProdutosCardapio = ?";

        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param(
            "sssssssi",
            $nomeProdutoCardapio,
            $descricao,
            $categoria,
            $tempoPreparo,
            $tipoMedida,
            $quantidade,
            $novaImagem,
            $id
        );

        $stmt_update->send_long_data(6, $novaImagem);

        if ($stmt_update->execute()) {
            header("Location: listaProdutoCardapio.php?status=success");
            exit;
        } else {
            header("Location: listaProdutoCardapio.php?status=error");
            exit;
        }

        $stmt_update->close();
    }
}

$idProdutoCardapio   = htmlspecialchars($produto['idProdutosCardapio']);
$nomeProdutoCardapio = htmlspecialchars($produto['nomeProdutoCardapio']);
$descricao           = htmlspecialchars($produto['descricao']);
$categoria           = htmlspecialchars($produto['categoria']);
$tempoPreparo        = htmlspecialchars($produto['tempoPreparo']);
$tipoMedida          = htmlspecialchars($produto['tipoMedida']);
$quantidade          = htmlspecialchars($produto['quantidadeMedida']);
$imagem              = $produto['imagem'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/formularioProdutosCardapio.css">
</head>
<body>

    <header>
        <a href="logout.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>
        <nav>
            <a href="paginaPrincipalFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="listaItemEstoque.php">ESTOQUE</a>
            <a href="listaProdutoCardapio.php">PRODUTOS</a>
            <a href="../php/aindaNao.php">FINANCEIRO</a>
            <a href="paginaRelatorios.php">RELATÓRIOS</a>
            <a href="formularioFuncionario.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'">Logout</button>
        </nav>
    </header>

    <div class="form-container">
        <h1>Editar Produto do Cardápio</h1>

        <form method="POST" enctype="multipart/form-data">

            <label>ID:</label>
            <input type="text" value="<?= $idProdutoCardapio ?>" disabled>

            <label for="nomeProdutoCardapio">Nome do Produto:</label>
            <input type="text" id="nomeProdutoCardapio" name="nomeProdutoCardapio"
                   value="<?= $nomeProdutoCardapio ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= $descricao ?></textarea>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Selecione</option>
                <option value="Entradas"          <?= $categoria == 'Entradas'          ? 'selected' : '' ?>>Entradas</option>
                <option value="Pratos Principais" <?= $categoria == 'Pratos Principais' ? 'selected' : '' ?>>Pratos Principais</option>
                <option value="Bebidas"           <?= $categoria == 'Bebidas'           ? 'selected' : '' ?>>Bebidas</option>
                <option value="Sobremesas"        <?= $categoria == 'Sobremesas'        ? 'selected' : '' ?>>Sobremesas</option>
            </select>

            <label for="tempoPreparo">Tempo de Preparo:</label>
            <input type="time" id="tempoPreparo" name="tempoPreparo"
                   value="<?= $tempoPreparo ?>" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidadeMedida"
                   value="<?= $quantidade ?>" required>

            <label for="tipoMedida">Tipo de Medida:</label>
            <select id="tipoMedida" name="tipoMedida" required>
                <option value="">Selecione</option>
                <option value="GM" <?= $tipoMedida == 'GM' ? 'selected' : '' ?>>Gramas</option>
                <option value="ML" <?= $tipoMedida == 'ML' ? 'selected' : '' ?>>Mililitros</option>
                <option value="L"  <?= $tipoMedida == 'L'  ? 'selected' : '' ?>>Litros</option>
            </select>

            <label>Imagem Atual:</label>
            <?php if (!empty($imagem)): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($imagem) ?>"
                     width="120" style="border-radius: 8px; margin-bottom: 10px; display: block;">
            <?php else: ?>
                <p>Sem imagem</p>
            <?php endif; ?>

            <label for="imagem">Alterar Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">

            <button class="submit-btn" type="submit">Atualizar Produto</button>

        </form>
    </div>

</body>
</html>