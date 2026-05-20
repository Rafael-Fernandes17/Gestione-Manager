<?php
require_once '../php/verificaPermissao.php'; 
verificaLogin(); 
include_once('../php/conexao.php');

$id = $_GET['id'] ?? null;
$item = null;

if ($id && is_numeric($id)) {
    $stmt = $conexao->prepare("SELECT nomeItem, tipoMedida, estoqueMinimo FROM itensEstoque WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    }
    $stmt->close();
}

if (!$item) {
    header("Location: listaItemEstoque.php");
    exit;
}

$nomeItemBD   = htmlspecialchars($item['nomeItem']);
$tipoMedidaBD = htmlspecialchars($item['tipoMedida'] ?? 'UN');
$saldoAtual   = (float)$item['estoqueMinimo'];

$mensagemAviso = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo       = $_POST['tipoMovimentacao'] ?? '';
    $quantidade = $_POST['quantidadeMovimento'] ?? 0;
    $motivo     = $_POST['motivoMovimento'] ?? '';

    if (empty($quantidade) || (float)$quantidade <= 0) {
        $mensagemAviso = "<script>alert('Erro: Informe uma quantidade válida e maior que zero.');</script>";
    } elseif (empty(trim($motivo))) {
        $mensagemAviso = "<script>alert('Erro: Escreva uma observação para a movimentação.');</script>";
    } else {
        // Lógica para tratar o Arquivamento da Nota Fiscal (Upload)
        $nomeArquivoSalvo = null;
        if ($tipo === 'entrada' && isset($_FILES['documentoNF']) && $_FILES['documentoNF']['error'] === UPLOAD_ERR_OK) {
            $diretorioDestino = '../uploads/notas_fiscais/';
            
            // Cria a pasta se ela não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0777, true);
            }
            
            $extensao = pathinfo($_FILES['documentoNF']['name'], PATHINFO_EXTENSION);
            $nomeArquivoSalvo = 'NF_' . time() . '_' . uniqid() . '.' . $extensao;
            
            // Move o arquivo temporário para a pasta definitiva
            move_uploaded_file($_FILES['documentoNF']['tmp_name'], $diretorioDestino . $nomeArquivoSalvo);
        }

        if ($tipo === 'entrada') {
            $novoSaldo = $saldoAtual + (float)$quantidade;
        } else if ($tipo === 'saida') {
            $novoSaldo = $saldoAtual - (float)$quantidade;
        }

        if ($tipo === 'saida' && $novoSaldo < 0) {
            $mensagemAviso = "<script>alert('Erro: Saldo insuficiente no estoque para realizar esta saída.');</script>";
        } else {
            $stmtUpdate = $conexao->prepare("UPDATE itensEstoque SET estoqueMinimo = ? WHERE id = ?");
            $stmtUpdate->bind_param("di", $novoSaldo, $id);

            if ($stmtUpdate->execute()) {
                // Opcional: Se você tiver uma tabela de histórico/log de movimentações no seu banco,
                // você pode salvar a variável $nomeArquivoSalvo nela aqui.
                echo "<script>
                        alert('Movimentação de estoque lançada com sucesso!');
                        window.location.href = 'listaItemEstoque.php';
                      </script>";
                exit;
            } else {
                $mensagemAviso = "<script>alert('Erro ao atualizar banco: " . $conexao->error . "');</script>";
            }
            $stmtUpdate->close();
        }
    }
}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestione Manager - Movimentação de Estoque</title>
    <link rel="icon" type="image/png" href="../img/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/cadastrarItemEstoque.css">
    <style>
        /* Estilização da barra informativa baseada na foto image_922faa.png */
        .info-header-box {
            background-color: #f7f5f0;
            border-left: 5px solid #bfa15f;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 35px;
            font-size: 15px;
            color: #333;
            line-height: 1.6;
        }
        .info-header-box strong {
            color: #2c3e50;
        }
        .saldo-destaque {
            color: #16a085 !important;
            font-weight: bold;
        }
        
        /* Classe para desabilitar visualmente os campos informativos do Grid */
        .field-readonly {
            background-color: #f5f5f5 !important;
            cursor: not-allowed;
        }
        .field-readonly input, .field-readonly select {
            color: #7f8c8d !important;
            pointer-events: none;
            cursor: not-allowed;
        }

        /* Ajuste fino para o campo de upload de arquivo */
        .input-field input[type="file"] {
            padding: 5px 0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php echo $mensagemAviso; ?>

    <header>
        <a href="logout.php" class="logo">
            <img src="../img/logo.jpeg" alt="Gestione Manager Logo">
            <span>Gestione Manager</span>
        </a>
        <nav>
            <a href="../indexFuncionario.php">HOME</a>
            <a href="aindaNao.php">DASHBOARD</a>
            <a href="aindaNao.php">CAIXA</a>
            <a href="../view/listaItemEstoque.php" class="active">ESTOQUE</a>
            <a href="../view/criandoProdutoCardapio.php">PRODUTOS</a>
            <a href="/Gestione-Manager/php/aindaNao.php">FINANCEIRO</a>
            <a href="/Gestione-Manager/php/aindaNao.php">RELATÓRIOS</a>
            <a href="/Gestione-Manager/php/cadastrarFuncionarioEstrutura.php">CADASTRAR FUNCIONÁRIOS</a>
            
            <button class="logout-btn" onclick="window.location.href='../php/logout.php'"> Logout </button>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1 style="text-align: center; margin-bottom: 25px;">Registrar Entrada / Saída</h1>
            
           
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-grid">
                    
                    <div class="input-box">
                        <label>ID do Item</label>
                        <div class="input-field field-readonly">
                            <span class="material-symbols-outlined">fingerprint</span>
                            <input type="text" value="#<?php echo $id; ?>" readonly tabindex="-1">
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Nome do Item</label>
                        <div class="input-field field-readonly">
                            <span class="material-symbols-outlined">inventory</span>
                            <input type="text" value="<?php echo $nomeItemBD; ?>" readonly tabindex="-1">
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Unidade de Medida</label>
                        <div class="input-field field-readonly">
                            <span class="material-symbols-outlined">straighten</span>
                            <select disabled tabindex="-1">
                                <option value="UN" <?php echo ($tipoMedidaBD === 'UN' || $tipoMedidaBD === 'UNI') ? 'selected' : ''; ?>>UN (Unidade)</option>
                                <option value="KG" <?php echo (strtoupper($tipoMedidaBD) === 'KG') ? 'selected' : ''; ?>>KG (Quilograma)</option>
                                <option value="G"  <?php echo (strtoupper($tipoMedidaBD) === 'G')  ? 'selected' : ''; ?>>G (Gramas)</option>
                                <option value="L"  <?php echo (strtoupper($tipoMedidaBD) === 'L')  ? 'selected' : ''; ?>>L (Litro)</option>
                                <option value="ML" <?php echo (strtoupper($tipoMedidaBD) === 'ML') ? 'selected' : ''; ?>>ML (Mililitro)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-box">
                        <label>Tipo de Operação</label>
                        <div class="input-field">
                            <span class="material-symbols-outlined">swap_vertical_circle</span>
                            <select name="tipoMovimentacao" id="tipoMovimentacao" onchange="gerenciarExibicaoNotaFiscal()">
                                <option value="entrada">📈 Entrada (Adicionar ao Estoque)</option>
                                <option value="saida">📉 Saída (Reduzir do Estoque)</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Quantidade (em <?php echo $tipoMedidaBD; ?>)</label>
                        <div class="input-field">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            <input type="number" step="0.01" name="quantidadeMovimento" id="quantidadeMovimento" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="input-box" id="boxNotaFiscal">
                        <label>Arquivar Nota Fiscal / Documento</label>
                        <div class="input-field">
                            <span class="material-symbols-outlined">upload_file</span>
                            <input type="file" name="documentoNF" id="documentoNF" accept="image/*,application/pdf">
                        </div>
                    </div>

                    
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Lançar no Estoque</button>
                </div>
            </form>
        </div>
    </main>

    <script>
    function gerenciarExibicaoNotaFiscal() {
        const tipo = document.getElementById('tipoMovimentacao').value;
        const boxNF = document.getElementById('boxNotaFiscal');
        const inputNF = document.getElementById('documentoNF');

        if (tipo === 'entrada') {
            boxNF.style.display = 'flex';
        } else {
            boxNF.style.display = 'none';
            inputNF.value = ''; // Limpa o arquivo caso mude para saída
        }
    }

    // Monitora a troca de abas caso o usuário mude o tipo de operação
    document.getElementById('tipoMovimentacao').addEventListener('change', gerenciarExibicaoNotaFiscal);
    </script>
</body>
</html>