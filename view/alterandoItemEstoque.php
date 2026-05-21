<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php'); // Sua conexão padrão do banco

// Verifica se veio um ID na URL (caso seja o modo de alteração)
$id = $_GET['id'] ?? null;
$item = null;
$modoEdicao = false;

if ($id && is_numeric($id)) {
    $modoEdicao = true;
    $stmt = $conexao->prepare("SELECT * FROM itensEstoque WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
        }
        $stmt->close();
    }
}

// Se tentou acessar a página de alteração sem um ID válido, volta para a lista
if (!$modoEdicao) {
    header("Location: listaItemEstoque.php");
    exit;
}

// Variáveis que vão preencher os campos com os dados vindos do banco
$nomeItemBD      = htmlspecialchars($item['nomeItem'] ?? '');
$categoriaBD     = htmlspecialchars($item['categoria'] ?? '');
$tipoMedidaBD    = htmlspecialchars($item['tipoMedida'] ?? '');
$fornecedorBD    = htmlspecialchars($item['fornecedor'] ?? '');
$valorBD         = htmlspecialchars($item['valorItem'] ?? '');
$estoqueMinimoBD = htmlspecialchars($item['estoqueMinimo'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Alterar Insumo</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/cadastrarItemEstoque.css">
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

    <main>
        <div class="container">
            <h1 id="tituloPagina">Alterar Insumo #<?= $id ?></h1>
            
            <input type="hidden" id="idItem" value="<?= $id ?>">

            <div class="form-grid">
                <div class="input-box">
                    <label>Nome do Insumo</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        <input type="text" id="nome" value="<?= $nomeItemBD ?>" placeholder="Ex: Farinha de Trigo Tipo 1" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Categoria</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">category</span>
                        <select id="categoria">
                            <option value="Ingredientes" <?= $categoriaBD === 'Ingredientes' ? 'selected' : '' ?>>Ingredientes</option>
                            <option value="Bebidas" <?= $categoriaBD === 'Bebidas' ? 'selected' : '' ?>>Bebidas</option>
                            <option value="Embalagens" <?= $categoriaBD === 'Embalagens' ? 'selected' : '' ?>>Embalagens</option>
                            <option value="Limpeza" <?= $categoriaBD === 'Limpeza' ? 'selected' : '' ?>>Limpeza</option>
                            <option value="Outros" <?= $categoriaBD === 'Outros' ? 'selected' : '' ?>>Outros</option>
                        </select>
                    </div>
                </div>

                <div class="input-box">
                    <label>Fornecedor Padrão</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">local_shipping</span>
                        <input type="text" id="fornecedor" value="<?= $fornecedorBD ?>" placeholder="Ex: Distribuidora Alvorada">
                    </div>
                </div>

                <div class="input-box">
                    <label>Valor Unitário Estimado (R$)</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">payments</span>
                        <input type="number" step="0.01" id="valor" value="<?= $valorBD ?>" placeholder="0.00">
                    </div>
                </div>

                <div class="input-box">
                    <label>Unidade de Medida</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">straighten</span>
                        <select id="unidade">
                            <option value="UN" <?= $tipoMedidaBD === 'UN' ? 'selected' : '' ?>>UN (Unidade)</option>
                            <option value="KG" <?= $tipoMedidaBD === 'KG' ? 'selected' : '' ?>>KG (Quilograma)</option>
                            <option value="G" <?= $tipoMedidaBD === 'G' ? 'selected' : '' ?>>G (Gramas)</option>
                            <option value="L" <?= $tipoMedidaBD === 'L' ? 'selected' : '' ?>>L (Litro)</option>
                            <option value="ML" <?= $tipoMedidaBD === 'ML' ? 'selected' : '' ?>>ML (Mililitro)</option>
                        </select>
                    </div>
                </div>

                <div class="input-box">
                    <label>Estoque Mínimo (Alerta)</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">warning</span>
                        <input type="number" step="0.01" id="estoqueMinimo" value="<?= $estoqueMinimoBD ?>" placeholder="Mínimo para alerta" required>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-submit" onclick="cadastrar()">Salvar Item</button>
            </div>
        </div>
    </main>

    <script src="../js/cadastrarItemEstoque.js" defer></script>
</body>
</html>