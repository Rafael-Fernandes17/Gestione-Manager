<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
include_once('../php/conexao.php');

$sql_itens_estoque = "SELECT id, nomeItem, tipoMedida, quantidadeUnitaria FROM itensEstoque";
$result_itens_estoque = $conexao->query($sql_itens_estoque);

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/formularioProdutosCardapio.css">
    <title>Gestione Manager - Cadastrar Produto</title>
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
        <h1>Cadastrar Produto para o Cardápio</h1>

        <form action="../php/cadastrarProdutoCardapio.php" method="post" enctype="multipart/form-data">

            <label for="nomeProdutoCardapio">Nome do Produto:</label>
            <input type="text" id="nomeProdutoCardapio" name="nomeProdutoCardapio" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Selecione</option>
                <option value="Entradas">Entradas</option>
                <option value="Pratos Principais">Pratos Principais</option>
                <option value="Bebidas">Bebidas</option>
                <option value="Sobremesas">Sobremesas</option>
            </select>

            <label for="tempoPreparo">Tempo de Preparo:</label>
            <input type="time" id="tempoPreparo" name="tempoPreparo" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>

            <label for="tipoMedida">Tipo de Medida:</label>
            <select id="tipoMedida" name="tipoMedida" required>
                <option value="">Selecione</option>
                <option value="GM">Gramas</option>
                <option value="ML">Mililitros</option>
                <option value="L">Litros</option>
            </select>

            <label for="imagem">Imagem do Produto:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>

            <label>Itens do Estoque (Ingredientes/Bebidas):</label>
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; max-height: 200px; overflow-y: auto; background: #fff;">
                <?php
                if ($result_itens_estoque && $result_itens_estoque->num_rows > 0) {
                    while ($row = $result_itens_estoque->fetch_assoc()) {
                        echo '
                        <label style="display: flex; align-items: center; gap: 10px; padding: 8px 5px; cursor: pointer; border-bottom: 1px solid #f0e8dc;">
                            <input type="checkbox" name="itensEstoque[]" value="' . $row["id"] . '"
                                style="width: 18px; height: 18px; accent-color: #5f0608; cursor: pointer;">
                            <span>' . htmlspecialchars($row["nomeItem"]) . '
                                (' . $row["quantidadeUnitaria"] . ' ' . $row["tipoMedida"] . ')
                            </span>
                        </label>';
                    }
                } else {
                    echo '<p style="color:#999;">Nenhum item disponível no estoque.</p>';
                }
                ?>
            </div>

            <button class="submit-btn" type="submit">Cadastrar Produto</button>
        </form>
    </div>

</body>
</html>