<?php
require_once("config/conexao.php");

$id = $_GET['id'];

$sql = "DELETE FROM usuarios WHERE id=$id";

if ($conn->query($sql)) {
    header("Location: listar.php");
}
?>