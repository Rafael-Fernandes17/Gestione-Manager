<?php

$servidor = 'localhost:3307';
$usuario = 'root';
$senha = '';
$nomeBanco = 'gestione_manager';

$conexao = new mysqli(
    $servidor,
    $usuario,
    $senha,
    $nomeBanco
);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");

?>