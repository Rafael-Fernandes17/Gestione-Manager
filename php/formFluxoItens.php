<?php
require_once 'verificaPermissao.php';
verificaLogin();
include_once('conexao.php');

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("<h3>ID inválido.</h3>");
}

try {
    // Agora buscamos também o valorItem (preço) do cadastro
    $stmt = $conexao->prepare("SELECT id, nomeItem, tipoMedida, fornecedor, valorItem FROM itensEstoque WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        die("<h3>Item não encontrado no estoque.</h3>");
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Movimentação - <?= htmlspecialchars($item['nomeItem']) ?></title>
    <link rel="stylesheet" href="../css/editProdutosCardapio.css">
    <style>
        .info-group { margin-bottom: 15px; }
        .info-label { font-weight: bold; color: #555; font-size: 0.9em; display: block; margin-bottom: 5px; }
        .info-value { 
            background: #f9f9f9; 
            padding: 10px; 
            border-radius: 4px; 
            border: 1px solid #ddd; 
            color: #333;
            font-family: sans-serif;
        }
        .destaque-preco { color: #2c3e50; font-weight: bold; }
        .btn-confirmar { 
            background-color: #27ae60; 
            color: white; 
            border: none; 
            padding: 15px; 
            width: 100%; 
            border-radius: 4px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 16px;
        }
        .btn-confirmar:hover { background-color: #219150; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2>Registro de Entrada e Saída</h2>

            <form action="processaFluxo.php" method="POST">
                <input type="hidden" name="idItem" value="<?= $item['id'] ?>">

                <div class="info-group">
                    <label class="info-label">ID do Item:</label>
                    <div class="info-value">#<?= $item['id'] ?></div>
                </div>

                <div class="info-group">
                    <label class="info-label">Nome do Insumo:</label>
                    <div class="info-value"><?= htmlspecialchars($item['nomeItem']) ?></div>
                </div>

                <div class="info-group">
                    <label class="info-label">Fornecedor:</label>
                    <div class="info-value"><?= htmlspecialchars($item['fornecedor']) ?></div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div class="info-group" style="flex: 1;">
                        <label class="info-label">Preço Unitário:</label>
                        <div class="info-value destaque-preco">R$ <?= number_format($item['valorItem'], 2, ',', '.') ?></div>
                    </div>
                    <div class="info-group" style="flex: 1;">
                        <label class="info-label">Unidade:</label>
                        <div class="info-value"><?= htmlspecialchars($item['tipoMedida']) ?></div>
                    </div>
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 2px dashed #eee;">

                <label>Tipo de Alteração:</label>
                <select name="tipoMovimentacao" required>
                    <option value="entrada" style="color: green;">⬆ ENTRADA (+)</option>
                    <option value="saida" style="color: red;">⬇ SAÍDA (-)</option>
                </select>

                <label>Quantidade a alterar:</label>
                <input type="number" step="0.01" name="quantidade" placeholder="0.00" required>

                <button type="submit" class="btn-confirmar">Atualizar Estoque</button>
                
                <a href="readItens.php" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>