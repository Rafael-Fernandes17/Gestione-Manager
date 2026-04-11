<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "127.0.0.1";
$usuario = "root";
$senha = "";
$nome_banco = "gestione_maganer";
$porta = 3307;

echo "Tentando conectar...<br>";

$conexao = new mysqli($servidor, $usuario, $senha, $nome_banco, $porta);

if ($conexao->connect_error) {
    die("Erro detectado: " . $conexao->connect_error);
} else {
    echo "<h1>Conexão realizada com sucesso na porta 3307!</h1>";
}
?>