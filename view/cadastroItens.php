<?php
    require_once '../php/verificaPermissao.php'; 
    verificaLogin(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Cadastro de Insumo</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/cadastrosItens.css">
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
            <a href="../view/cadastroItens.php" class="active">ESTOQUE</a>
            <a href="criandoProdutoCardapio.html">PRODUTOS</a>
            <a href="/Gestione-Manager/php/aindaNao.php">FINANCEIRO</a>
            <a href="/Gestione-Manager/php/aindaNao.php">RELATÓRIOS</a>
            <a href="/Gestione-Manager/php/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>

            
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'"> Logout </button>
        </nav>
    </header>
    <div class="container">
        <h1>Configurar Novo Insumo</h1>
        <div class="form-grid">
            <div class="input-box">
                <label>Nome do Item</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">inventory</span>
                    <input type="text" id="nome" placeholder="Ex: Carne">
                </div>
            </div>

            <div class="input-box">
                <label>Categoria</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">category</span>
                    <select id="categoria">
                        <option value="ingredientes">Ingredientes</option>
                        <option value="bebidas">Bebidas</option>
                    </select>
                </div>
            </div>

            <div class="input-box">
                <label>Fornecedor</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">local_shipping</span>
                    <input type="text" id="fornecedor" placeholder="Nome do fornecedor">
                </div>
            </div>

            <div class="input-box">
                <label>Valor Unitário (R$)</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">payments</span>
                    <input type="number" step="0.01" id="valor" placeholder="0.00">
                </div>
            </div>

            <div class="input-box">
                <label>Unidade de Medida</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">straighten</span>
                    <input type="text" id="unidade" placeholder="KG, L, UNI">
                </div>
            </div>

            <div class="input-box">
                <label>Estoque Mínimo (Alerta)</label>
                <div class="input-field">
                    <span class="material-symbols-outlined">warning</span>
                    <input type="number" step="0.01" id="estoqueMinimo" placeholder="Mínimo para alerta">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-cadastrar" onclick="cadastrar()">Salvar Item</button>
        </div>
    </div>

    </main>
</div>
<script src="../js/cadastroItens.js" defer></script>

    <script src="../js/cadastroItens.js"></script>
</body>
</html>