<?php
// Desativar a exibição de erros na tela para evitar quebrar o JSON
ini_set("display_errors", 0);
error_reporting(0);

require_once 'conexao.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response = ['status' => 'nok', 'message' => 'Erro desconhecido.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $userId = $_SESSION['usuario']['id'] ?? null;

    if (!$userId) {
        $response['message'] = 'Usuário não logado.';
    } elseif (empty($novaSenha) || empty($confirmarSenha)) {
        $response['message'] = 'Todos os campos são obrigatórios.';
    } elseif ($novaSenha !== $confirmarSenha) {
        $response['message'] = 'As senhas não coincidem.';
    } else {
        // Hash da nova senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        try {
            // Usar a conexão PDO global
            global $conexao;
            $stmt = $conexao->prepare('UPDATE funcionario SET senha = :senha, primeiroAcesso = FALSE WHERE id = :id');
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['usuario']['primeiroAcesso'] = FALSE; // Atualiza a sessão
                $response['status'] = 'ok';
                $response['message'] = 'Senha alterada com sucesso!';
            } else {
                $response['message'] = 'Não foi possível alterar a senha. Usuário não encontrado ou senha já atualizada.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Erro ao atualizar a senha no banco de dados: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método de requisição inválido.';
}

echo json_encode($response);
?>
