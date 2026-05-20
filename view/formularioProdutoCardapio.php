<?php
    require_once '../php/verificaPermissao.php'; 
    verificaLogin(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="../css/formularioProdutosCardapio.css">
    <title>Cadastrar Produto</title>
</head>
<body>

    <header>
        <a href="../php/logout.php" class="logo">
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

            <label for="preco">Preço:</label>  
            <input type="number" id="preco" name="preco" step="0.01" required> 

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

            <label for="statusProdutos">Status:</label>          
            <select id="statusProdutos" name="statusProdutos" required> 
                <option value="">Selecione</option> 
                <option value="Disponível">Disponível</option> 
                <option value="Indisponível">Indisponível</option> 
            </select> 

            <button class="submit-btn" type="submit" id="botao">Cadastrar Produto</button> 
        </form>
    </div>

    <script src="../js/cadastrarProdutoCardapio.js" defer></script>
</body>
</html>