<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php'); // Sua conexão padrão do banco

// Verifica se veio um ID na URL para saber se é Modo Edição (ex: formularioItemEstoque.php?id=14)
$id = $_GET['id'] ?? null;
$item = null;
$modoEdicao = false;

if ($id && is_numeric($id)) {
    $modoEdicao = true;
    
    // Busca os dados do banco usando o ID recebido
    $stmt = $conexao->prepare("SELECT * FROM itensEstoque WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    }
    $stmt->close();
}

// Prepara as variáveis para os inputs (vazias se for cadastro, preenchidas se for alteração)
$nomeItemBD      = $modoEdicao ? htmlspecialchars($item['nomeItem'] ?? '') : '';
$categoriaBD     = $modoEdicao ? htmlspecialchars($item['categoria'] ?? '') : '';
$tipoMedidaBD    = $modoEdicao ? htmlspecialchars($item['tipoMedida'] ?? '') : '';
$fornecedorBD    = $modoEdicao ? htmlspecialchars($item['fornecedor'] ?? '') : '';
$valorBD         = $modoEdicao ? htmlspecialchars($item['valorItem'] ?? '') : '';
$estoqueMinimoBD = $modoEdicao ? htmlspecialchars($item['estoqueMinimo'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - <?php echo $modoEdicao ? 'Alterar' : 'Cadastro de'; ?> Insumo</title>
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
            <a href="../indexFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="formularioItemEstoque.php" class="active">ESTOQUE</a>
            <a href="formularioProdutoCardapio.php">PRODUTOS</a>
            <a href="/Gestione-Manager/php/aindaNao.php">FINANCEIRO</a>
            <a href="/Gestione-Manager/php/aindaNao.php">RELATÓRIOS</a>
            <a href="/Gestione-Manager/php/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'"> Logout </button>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1><?php echo $modoEdicao ? 'Alterar Insumo #' . $id : 'Configurar Novo Insumo'; ?></h1>
            
            <input type="hidden" id="idItem" value="<?php echo $modoEdicao ? $id : ''; ?>">

            <div class="form-grid">
                <div class="input-box">
                    <label>Nome do Item</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">inventory</span>
                        <input type="text" id="nome" placeholder="Ex: Carne" value="<?php echo $nomeItemBD; ?>">
                    </div>
                </div>

                <div class="input-box">
                    <label>Categoria</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">category</span>
                        <select id="categoria">
                            <option value="ingredientes" <?php echo ($categoriaBD == 'ingredientes') ? 'selected' : ''; ?>>Ingredientes</option>
                            <option value="bebidas" <?php echo ($categoriaBD == 'bebidas') ? 'selected' : ''; ?>>Bebidas</option>
                        </select>
                    </div>
                </div>

                <div class="input-box">
                    <label>Fornecedor</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">local_shipping</span>
                        <input type="text" id="fornecedor" placeholder="Nome do fornecedor" value="<?php echo $fornecedorBD; ?>">
                    </div>
                </div>

                <div class="input-box">
                    <label>Valor Unitário (R$)</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">payments</span>
                        <input type="number" step="0.01" id="valor" placeholder="0.00" value="<?php echo $valorBD; ?>">
                    </div>
                </div>

                <div class="input-box">
                    <label>Unidade de Medida</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">straighten</span>
                        <input type="text" id="unidade" placeholder="KG, L, UNI" value="<?php echo $tipoMedidaBD; ?>">
                    </div>
                </div>

                <div class="input-box">
                    <label>Estoque Mínimo (Alerta)</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">warning</span>
                        <input type="number" step="0.01" id="estoqueMinimo" placeholder="Mínimo para alerta" value="<?php echo $estoqueMinimoBD; ?>">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-submit" onclick="cadastrar()"><?php echo $modoEdicao ? 'Atualizar Dados' : 'Salvar Item'; ?></button>
            </div>
        </div>
    </main>

    <script src="../js/cadastrarItemEstoque.js" defer></script>
</body>
</html>