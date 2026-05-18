<?php
    require_once '../php/verificaPermissao.php'; 
    verificaLogin(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Manager - Cadastro de Insumos</title>
    <link rel="stylesheet" href="../css/resetando.css">
    <link rel="stylesheet" href="../css/cadastrarItemEstoque.css">
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

    <main class="content">
        <div class="form-container">
            <div class="form-header">
                <h3>Novo Registro</h3>
                <p>Identifique se o item é um insumo de cozinha ou produto de bar.</p>
            </div>

            <div class="form-grid">
                <div class="input-box full-width">
                    <label>Nome do Item</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">edit_note</span>
                        <input type="text" id="nome" placeholder="Ex: Filé Mignon ou Coca-Cola 350ml" name="nomeItem">
                    </div>
                </div>

                <div class="input-box">
                    <label>Categoria</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">layers</span>
                        <select id="categoria" name="categoria">
                            <option value="">Selecione...</option>
                            <option value="ingredientes">Ingrediente (Cozinha)</option>
                            <option value="bebidas">Bebida (Bar)</option>
                        </select>
                    </div>
                </div>

                <div class="input-box">
                    <label>Unidade de Medida</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">straighten</span>
                        <select id="tipoMedida" name="tipoMedida">
                            <option value="">Selecione...</option>
                            <option value="KG">Quilograma (kg)</option>
                            <option value="MG">Miligrama (mg)</option>
                            <option value="G">Grama (g)</option>
                            <option value="L">Litro (l)</option>
                            <option value="ML">Mililitro (ml)</option>
                            <option value="UN">Unidade (un)</option>
                        </select>
                    </div>
                </div>

                <div class="input-box full-width">
                    <label>Quantidade em Estoque</label>
                    <div class="input-field">
                        <span class="material-symbols-outlined">inventory_2</span>
                        <input type="number" id="quantidade" placeholder="0.00" name="quantidadeEstoque">
                    </div>
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
<script src="../js/cadastrarItemEstoque.js" defer></script>

    <script src="../js/cadastroItens.js"></script>
</body>
</html>