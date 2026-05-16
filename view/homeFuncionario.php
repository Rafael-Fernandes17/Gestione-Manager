<?php
    require_once './php/verificaPermissao.php'; 
    verificaLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/registerFuncionario.css">
    <script src='js/filtraSessao.js' defer></script>
    <title>Document</title>
</head>
<body>
     <header>
        <a href="./php/logout.php" class="logo">
            <img src="./img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>

        <nav>
            <a href="homeFuncionario.php">HOME</a>
            <a href="./php/aindaNao.php">DASHBOARD</a>
            <a href="./php/aindaNao.php">CAIXA</a>
            <a href="cadastroItens.php">ESTOQUE</a>
            <a href="criandoProdutoCardapio.php">PRODUTOS</a>
            <a href="./php/aindaNao.php">FINANCEIRO</a>
            <a href="./php/aindaNao.php">RELATÓRIOS</a>
            <a href="registerFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            <button class="logout-btn" onclick="window.location.href='./php/logout.php'"> Logout </button>
        </nav>
    </header>
</body>
</html>