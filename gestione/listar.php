<?php
require_once("config/conexao.php");

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<h2>🍝 Funcionários</h2>

<a href="cadastrar.php">Cadastrar</a><br><br>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Ações</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['nome'] ?></td>
    <td><?= $row['email'] ?></td>
    <td>
        <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> |
        <a href="deletar.php?id=<?= $row['id'] ?>">Excluir</a>
    </td>
</tr>
<?php } ?>
</table>