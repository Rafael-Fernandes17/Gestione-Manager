<?php
require_once 'verificaPermissao.php';

function sendJsonResponse($status, $message, $redirect = null) {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message, 'redirect' => $redirect]);
    exit;
}

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    verificaLogin();
    include_once('conexao.php');
} else {
    verificaLogin();
    include_once('conexao.php');
}

$mensagemAviso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_item = $_POST['id_item'] ?? null;
    $tipo = $_POST['tipoMovimentacao'] ?? '';
    $quantidade = $_POST['quantidadeMovimento'] ?? 0;
    $motivoSelecionado = $_POST['motivoMovimento'] ?? '';
    $motivoDescrito = $_POST['motivoMovimentoDescricao'] ?? '';

    if (empty($id_item) || !is_numeric($id_item)) {
        if ($isAjax) sendJsonResponse('error', 'Erro: ID do item inválido.', 'listaItemEstoque.php');
        else $mensagemAviso = "<script>alert('Erro: ID do item inválido.'); window.location.href = '../view/listaItemEstoque.php';</script>";
    } elseif (empty($quantidade) || (float)$quantidade <= 0) {
        if ($isAjax) sendJsonResponse('error', 'Erro: Informe uma quantidade válida e maior que zero.');
        else $mensagemAviso = "<script>alert('Erro: Informe uma quantidade válida e maior que zero.');</script>";
    } else {
        $motivoFinal = '';
        if ($tipo === 'saida') {
            $motivoFinal = ($motivoSelecionado === 'outros') ? $motivoDescrito : $motivoSelecionado;
            if (empty(trim($motivoFinal))) {
                if ($isAjax) sendJsonResponse('error', 'Erro: Especifique ou selecione o motivo da saída.');
                else $mensagemAviso = "<script>alert('Erro: Especifique ou selecione o motivo da saída.');</script>";
            }
        } else {
            $motivoFinal = 'Entrada de material/Compra';
        }

        if (empty($mensagemAviso)) {
            $documentoNF = null;
            $documentoNFTipo = null;
            if ($tipo === 'entrada' && isset($_FILES['documentoNF']) && $_FILES['documentoNF']['error'] === UPLOAD_ERR_OK) {
                $documentoNF = file_get_contents($_FILES['documentoNF']['tmp_name']);
                $documentoNFTipo = $_FILES['documentoNF']['type'];
            }

            $stmtSaldo = $conexao->prepare("SELECT quantidadeUnitaria FROM itensEstoque WHERE id = ?");
            $stmtSaldo->bind_param("i", $id_item);
            $stmtSaldo->execute();
            $resultSaldo = $stmtSaldo->get_result();
            $itemEstoque = $resultSaldo->fetch_assoc();
            $saldoAtual = (float)$itemEstoque["quantidadeUnitaria"];
            $stmtSaldo->close();

            $novoSaldo = $saldoAtual;
            if ($tipo === 'entrada') {
                $novoSaldo = $saldoAtual + (float)$quantidade;
            } else if ($tipo === 'saida') {
                $novoSaldo = $saldoAtual - (float)$quantidade;
            }

            if ($tipo === 'saida' && $novoSaldo < 0) {
                if ($isAjax) sendJsonResponse('error', 'Erro: Saldo insuficiente no estoque para realizar esta saída.');
                else $mensagemAviso = "<script>alert('Erro: Saldo insuficiente no estoque para realizar esta saída.');</script>";
            } else {
                $conexao->begin_transaction();

                try {
                    $stmtInsertFluxo = $conexao->prepare("INSERT INTO fluxoEstoque (id_item, tipo_operacao, quantidade, motivo, documento_nf, documento_nf_tipo) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmtInsertFluxo->bind_param("isdsss", $id_item, $tipo, $quantidade, $motivoFinal, $documentoNF, $documentoNFTipo);
                    
                    if ($documentoNF !== null) {
                        $stmtInsertFluxo->send_long_data(4, $documentoNF);
                    }
                    
                    $stmtInsertFluxo->execute();
                    $stmtInsertFluxo->close();

                    $stmtUpdateEstoque = $conexao->prepare("UPDATE itensEstoque SET quantidadeUnitaria = ? WHERE id = ?");
                    $stmtUpdateEstoque->bind_param("di", $novoSaldo, $id_item);
                    $stmtUpdateEstoque->execute();
                    $stmtUpdateEstoque->close();

                    $conexao->commit();
                    if ($isAjax) sendJsonResponse('success', 'Movimentação de estoque lançada com sucesso!', 'listaItemEstoque.php');
                    else $mensagemAviso = "<script>alert('Movimentação de estoque lançada com sucesso!'); window.location.href = '../view/listaItemEstoque.php';</script>";
                } catch (mysqli_sql_exception $exception) {
                    $conexao->rollback();
                    if ($isAjax) sendJsonResponse('error', 'Erro ao lançar movimentação: ' . $exception->getMessage());
                    else $mensagemAviso = "<script>alert('Erro ao lançar movimentação: " . $exception->getMessage() . "');</script>";
                }
            }
        }
    }
}

$conexao->close();
if (!$isAjax) echo $mensagemAviso;
?>
