<?php
include_once('conexao.php');

header("Content-Type: application/json");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM ingrediente WHERE id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo json_encode([
            'status' => 'ok',
            'mensagem' => 'Ingrediente excluído'
        ]);
    } else {
        echo json_encode([
            'status' => 'nok',
            'mensagem' => 'Erro ao excluir'
        ]);
    }
    
    $stmt->close();
}

$conexao->close();
?>