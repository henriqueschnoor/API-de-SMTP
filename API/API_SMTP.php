<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/../')->load();

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}
    $nome = trim($data['nome'] ?? '');
    $email = trim($data['email'] ?? '');
    $mensagem = trim($data['mensagem'] ?? '');

if ($nome === ''|| $email === ''|| $mensagem === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Todos os campos são obrigatórios']);
    exit;
}
$smtp = new PHPMailer(true);
try {
    $smtp->SMTPDebug  = SMTP::DEBUG_OFF;
    $smtp->isSMTP();
    $smtp->Host = $_ENV['HOST'];
    $smtp->SMTPAuth = true;
    $smtp->Username = $_ENV['USER_NAME'];
    $smtp->Password = $_ENV['SENHA'];
    $smtp->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $smtp->Port = (int) $_ENV['PORT'];

    $smtp->setFrom($_ENV['USER_NAME'], $_ENV['NOME_SUPORTE']);
    $smtp->addAddress($email, $nome);

    $smtp->isHTML(true);
    $smtp->CharSet   = 'UTF-8';
    $smtp->Encoding  = 'base64';
    $smtp->Subject   = "Contato de {$nome}";
    $smtp->Body      = "
        <div style='font-family:Arial,sans-serif;color:#333'>
            <h3>Olá, {$nome}! 😊</h3>
            <p>Seu teste de e-mail foi um sucesso!</p>
            <p>Obrigado pelo feedback.</p>
        </div>";
    $smtp->AltBody   = "Nome: {$nome}\nE-mail: {$email}\nMensagem:\n{$mensagem}";

    $smtp->send();

    echo json_encode([
        'status'  => 'success',
        'message' => 'E-mail enviado com sucesso',
        'data'    => compact('nome','email','mensagem')
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    exit;
}
