<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
/*--------------------------------------------------------------------------------------------------------------
                                             SMTP PHPMailer
----------------------------------------------------------------------------------------------------------------*/
$smtp = new PHPMailer(true);

try{
$smtp -> SMTPDebug = DEBUG_SERVER;
$smtp -> isSMTP();
$smtp -> Host = 'smtp.exemple.com'; 
$smtp -> SMTPAuth = true;
$smtp -> Username = 'user@exemplo.com';
$smtp -> Password = 'senha';
$smtp -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$smtp -> Port = 465; 

$smtp -> setForm('from@exemplo.com', 'Seu Nome ou App');

$smtp -> addAddress('destinatario@exemplo.com', 'Destinatario'); // nome destinatario
$smtp -> addReplyTo('info@exemplo.com', 'Suporte');  // a resposta irá nesse email
$smtp -> addCC('copia@exemplo.com');
$smtp -> addCC('copia_oculta@exemplo.com');

$mail->isHTML(true);                        
    $mail->Subject = 'Assunto do e-mail';
    $mail->Body    = '<h1>Olá!</h1><p>Corpo em <b>HTML</b>.</p>';
    $mail->AltBody = 'Versão texto puro para quem não lê HTML.';

    $mail->send();
    echo 'Mensagem enviada com sucesso';
} catch (Exception $e) {
    echo "Mensagem de erro: {$mail->ErrorInfo}";
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
