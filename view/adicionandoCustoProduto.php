<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
verificaAdm();
include_once('../php/conexao.php');

$produto = null;
$ingredientesDoProduto = [];

if (isset($_GET["idProduto"]) && !empty($_GET["idProduto"])) {
    $idProduto = $_GET["idProduto"];

    $stmt_produto = $conexao->prepare("SELECT idProdutosCardapio, nomeProdutoCardapio FROM produtoCardapio WHERE idProdutosCardapio = ?");
    $stmt_produto->bind_param("i", $idProduto);
    $stmt_produto->execute();
    $result_produto = $stmt_produto->get_result();
    if ($result_produto->num_rows > 0) {
        $produto = $result_produto->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit();
    }
    $stmt_produto->close();

    $stmt_ingredientes = $conexao->prepare("
        SELECT ie.id, ie.nomeItem, ie.tipoMedida, ie.quantidadeUnitaria, ie.valorItem
        FROM produto_ingrediente pi
        JOIN itensEstoque ie ON pi.idItemEstoque = ie.id
        WHERE pi.idProduto = ?
    ");
    $stmt_ingredientes->bind_param("i", $idProduto);
    $stmt_ingredientes->execute();
    $result_ingredientes = $stmt_ingredientes->get_result();
    while ($row = $result_ingredientes->fetch_assoc()) {
        $ingredientesDoProduto[] = $row;
    }
    $stmt_ingredientes->close();

} else {
    echo "ID do produto não fornecido.";
    exit();
}

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Manager - Definir Preço do Produto</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/listaProdutosCardapio.css">
    <style>
        .container-custo {
            background: #fdfaf6;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 40px auto;
        }
        h1, h2, h3 { color: #5f0608; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="number"], input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #5f0608;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover { background-color: #a80000; }
        .ingredient-item { display: flex; align-items: center; margin-bottom: 10px; gap: 10px; }
        .ingredient-item label { flex: 2; margin-bottom: 0; }
        .ingredient-item input { flex: 1; margin: 0; }
        .calculation-result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f7f0e6;
            border-left: 4px solid #d19035;
            border-radius: 4px;
        }
        .error { color: red; font-size: 13px; }
    </style>
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

    <div class="container-custo">
        <h1>Definir Preço para o Produto</h1>
        <?php if ($produto): ?>
            <h2>Produto: <?php echo htmlspecialchars($produto["nomeProdutoCardapio"]); ?> (ID: <?php echo htmlspecialchars($produto["idProdutosCardapio"]); ?>)</h2>

            <form action="../php/salvandoPrecoProduto.php" method="post">
                <input type="hidden" name="idProduto" value="<?php echo htmlspecialchars($produto["idProdutosCardapio"]); ?>">

                <h3>Itens do Estoque e Quantidade Utilizada:</h3>
                <?php if (!empty($ingredientesDoProduto)): ?>
                    <?php foreach ($ingredientesDoProduto as $ingrediente): ?>
                        <div class="ingredient-item">
                            <label for="quantidade_<?php echo $ingrediente["id"]; ?>">
                                <?php echo htmlspecialchars($ingrediente["nomeItem"]); ?>
                                (Estoque: <?php echo htmlspecialchars($ingrediente["quantidadeUnitaria"]); ?> <?php echo htmlspecialchars($ingrediente["tipoMedida"]); ?>)
                                (Valor Unit.: R$ <?php echo number_format($ingrediente["valorItem"], 2, ",", "."); ?>)
                            </label>
                            <input type="number"
                                   id="quantidade_<?php echo $ingrediente["id"]; ?>"
                                   name="quantidades[<?php echo $ingrediente["id"]; ?>]"
                                   min="0.001" step="0.001" value="1" required
                                   data-custo-unitario="<?php echo htmlspecialchars($ingrediente["valorItem"]); ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum ingrediente associado a este produto.</p>
                <?php endif; ?>

                <hr>

                <div class="calculation-result">
                    <p>Preço Bruto: <span id="precoBruto">R$ 0,00</span></p>
                    <label for="margemLucro">Margem de Lucro Sugerida (%):</label>
                    <input type="number" id="margemLucro" name="margemLucro" value="30" min="0" step="1">
                    <p>Preço Final Sugerido: <span id="precoFinalSugerido">R$ 0,00</span></p>

                    <label for="precoFinal">Preço Final (Editável):</label>
                    <input type="number" id="precoFinal" name="precoFinal" step="0.01" min="0" required>
                    <p class="error" id="precoFinalError"></p>
                </div>

                <input type="submit" value="Salvar Preço e Disponibilizar Produto">
            </form>
        <?php else: ?>
            <p>Produto não encontrado ou ID inválido.</p>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantidadeInputs = document.querySelectorAll('.ingredient-item input[type="number"]');
        const margemLucroInput = document.getElementById('margemLucro');
        const precoBrutoSpan   = document.getElementById('precoBruto');
        const precoFinalSugeridoSpan = document.getElementById('precoFinalSugerido');
        const precoFinalInput  = document.getElementById('precoFinal');
        const precoFinalError  = document.getElementById('precoFinalError');

        function calcularPrecos() {
            let precoBruto = 0;
            quantidadeInputs.forEach(input => {
                const qtd   = parseFloat(input.value) || 0;
                const custo = parseFloat(input.dataset.custoUnitario) || 0;
                if (qtd > 0) precoBruto += custo * qtd;
            });

            const margem = parseFloat(margemLucroInput.value) || 0;
            const sugerido = precoBruto * (1 + margem / 100);

            precoBrutoSpan.textContent        = 'R$ ' + precoBruto.toFixed(2).replace('.', ',');
            precoFinalSugeridoSpan.textContent = 'R$ ' + sugerido.toFixed(2).replace('.', ',');

            if (precoFinalInput.value === '' || parseFloat(precoFinalInput.value) < precoBruto) {
                precoFinalInput.value = sugerido.toFixed(2);
            }
            validarPrecoFinal();
        }

        function validarPrecoFinal() {
            const bruto = parseFloat(precoBrutoSpan.textContent.replace('R$', '').replace(',', '.').trim());
            const final = parseFloat(precoFinalInput.value);
            if (isNaN(final) || final < bruto) {
                precoFinalError.textContent = 'O preço final não pode ser menor que o preço bruto.';
                precoFinalInput.setCustomValidity('Preço inválido.');
            } else {
                precoFinalError.textContent = '';
                precoFinalInput.setCustomValidity('');
            }
        }

        quantidadeInputs.forEach(i => i.addEventListener('input', calcularPrecos));
        margemLucroInput.addEventListener('input', calcularPrecos);
        precoFinalInput.addEventListener('input', validarPrecoFinal);
        calcularPrecos();
    });
    </script>
</body>
</html>