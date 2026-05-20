<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php'); // Sua conexão oficial com o banco

// 1. CAPTURA O ID DO ITEM QUE VEIO DA LISTA
$id = $_GET['id'] ?? null;
$item = null;

if (!$id || !is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

// Busca as novas informações solicitadas no segundo modelo
$stmt = $conexao->prepare("SELECT id, nomeItem, tipoMedida, fornecedor, valorItem FROM itensEstoque WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $item = $result->fetch_assoc();
}
$stmt->close();

// Se não achar o item, para o script
if (!$item) {
    die("<h3>Item não encontrado no estoque.</h3>");
}

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Movimentação de Estoque</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/cadastrarItemEstoque.css">
    <style>
        /* Estilos extras para acomodar as novas informações fixas */
        .info-container {
            background: #fdfdfd;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #eef2f5;
            margin-bottom: 25px;
        }
        .info-grid-dados {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .info-label { font-weight: bold; color: #7f8c8d; font-size: 0.85em; display: block; margin-bottom: 2px; text-transform: uppercase; }
        .info-value { color: #2c3e50; font-size: 15px; font-weight: 500; }
        .destaque-preco { color: #27ae60; font-weight: bold; }
    </style>
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
            <a href="../view/listaItemEstoque.php" class="active">ESTOQUE</a>
            <a href="../view/criandoProdutoCardapio.php">PRODUTOS</a>
            <a href="/Gestione-Manager/php/aindaNao.php">FINANCEIRO</a>
            <a href="/Gestione-Manager/php/aindaNao.php">RELATÓRIOS</a>
            <a href="/Gestione-Manager/php/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'"> Logout </button>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Registro de Entrada e Saída</h1>
            
            <div class="info-container">
                <div class="info-grid-dados">
                    <div>
                        <span class="info-label">ID do Item:</span>
                        <div class="info-value">#<?= $item['id'] ?></div>
                    </div>
                    <div>
                        <span class="info-label">Nome do Insumo:</span>
                        <div class="info-value"><?= htmlspecialchars($item['nomeItem']) ?></div>
                    </div>
                    <div>
                        <span class="info-label">Fornecedor:</span>
                        <div class="info-value"><?= htmlspecialchars($item['fornecedor']) ?></div>
                    </div>
                    <div>
                        <span class="info-label">Preço Unitário:</span>
                        <div class="info-value destaque-preco">R$ <?= number_format($item['valorItem'], 2, ',', '.') ?></div>
                    </div>
                    <div>
                        <span class="info-label">Unidade de Medida:</span>
                        <div class="info-value"><?= htmlspecialchars($item['tipoMedida']) ?></div>
                    </div>
                </div>
            </div>
            
            <form action="processaFluxo.php" method="POST">
                <input type="hidden" name="idItem" value="<?= $item['id'] ?>">

                <div class="form-grid">
                    <div class="input-box">
                        <label>Tipo de Alteração</label>
                        <div class="input-field">
                            <span class="material-symbols-outlined">swap_vertical_circle</span>
                            <select name="tipoMovimentacao" id="tipoMovimentacao" required>
                                <option value="entrada" style="color: green;">📈 ⬆ ENTRADA (+)</option>
                                <option value="saida" style="color: red;">📉 ⬇ SAÍDA (-)</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Quantidade a alterar (em <?= htmlspecialchars($item['tipoMedida']) ?>)</label>
                        <div class="input-field">
                            <span class="material-symbols-outlined">shopping_product</span>
                            <input type="number" step="0.01" name="quantidade" id="quantidade" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Atualizar Estoque</button>
                </div>

                <a href="readItens.php" style="display: block; text-align: center; margin-top: 20px; color: #666; text-decoration: none; font-size: 14px;">Voltar</a>
            </form>
        </div>
    </main>
</body>
</html>