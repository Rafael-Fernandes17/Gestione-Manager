<?php 

$servidor = 'localhost:3307';
$usuario = 'root';
$senha = ''; 
$nome_banco = 'gestione_manager';

$conexao = new mysqli($servidor, $usuario, $senha, $nome_banco);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

?>