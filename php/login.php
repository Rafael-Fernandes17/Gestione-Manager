<?php
    require_once 'verificaPermissao.php';
    $resultado = realizarLogin();

    $retorno = [
        'status' => '',
        'mensagem' => '',
        'dados' => ''
    ];


    if ($resultado !== 'login nao realizado') {
        $retorno = ['status' => 'ok', 'mensagem' => 'cadastro realizado com sucesso'];
    } else {
        $retorno = ['status' => 'nok', 'mensagem' => 'credenciais invalidas'];
    }

header('Content-Type: application/json');
echo json_encode($retorno);
exit;