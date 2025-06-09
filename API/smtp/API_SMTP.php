<?php
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($json === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalido o JSON enviado']);
    exit;
}

$nome = $data['nome'] ?? null;
$email = $data['email'] ?? null;
$mensagem = $data['mensagem'] ?? null;

if (empty($nome) || empty($email) || empty($mensagem)) {
    http_response_code(400);
    echo json_encode(['error' => 'Todos os campos são obrigatórios']);
    exit;
}   

echo json_encode([
    'status' => 'success',
    'message' => 'Dados recebidos com sucesso',
    'data' => [
        'nome' => $nome,
        'email' => $email,
        'mensagem' => $mensagem
    ]
]);
exit;
