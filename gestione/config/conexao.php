<?php
$conn = new mysqli("127.0.0.1", "root", "", "gestione", 3307);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>