<?php
require_once("config/conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id=$id";
$user = $conn->query($sql)->fetch_assoc();
?>

<form method="POST" action="atualizar.php">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    Nome: <input type="text" name="nome" value="<?= $user['nome'] ?>"><br><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>"><br><br>

    <button>Atualizar</button>
</form>