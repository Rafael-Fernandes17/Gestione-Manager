<?php
require_once '../php/verificaPermissao.php';
verificaLogin();
include_once("../php/conexao.php");

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

    // Use get_result() em vez de bind_result() para BLOBs
    $stmt = $conexao->prepare("SELECT documento_nf, documento_nf_tipo FROM fluxoEstoque WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row && $row['documento_nf'] && $row['documento_nf_tipo']) {
        $tipo = $row['documento_nf_tipo'];
        $dados = $row['documento_nf'];

        header("Content-Type: " . $tipo);
        // inline = exibe no browser | attachment = força download
        header("Content-Disposition: inline; filename=\"nota_fiscal_" . $id . "\"");
        header("Content-Length: " . strlen($dados));
        
        // Limpa qualquer output antes de enviar o binário
        ob_clean();
        flush();
        
        echo $dados;
    } else {
        echo "Documento não encontrado.";
    }
} else {
    echo "ID de documento inválido.";
}
$conexao->close();
?>