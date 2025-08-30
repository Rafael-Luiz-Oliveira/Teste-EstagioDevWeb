<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Método não permitido.');
}

// Sanitização básica
$nome     = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email    = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

$erros = [];

// Validação servidor
if (mb_strlen($nome) < 3) {
  $erros[] = 'Nome inválido.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $erros[] = 'E-mail inválido.';
}
if (mb_strlen($telefone) < 8) {
  $erros[] = 'Telefone inválido.';
}
if (mb_strlen($mensagem) < 10) {
  $erros[] = 'Mensagem muito curta.';
}

if ($erros) {
  http_response_code(422);
  echo '<h2>Erros de validação:</h2><ul>';
  foreach ($erros as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
  echo '</ul><p><a href="/src/index.html">Voltar</a></p>';
  exit;
}

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host       = $_ENV['MAIL_HOST'];
  $mail->SMTPAuth   =  true;
  $mail->Username   = $_ENV['MAIL_USERNAME'];
  $mail->Password   = $_ENV['MAIL_PASSWORD'];
  $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
  $mail->Port       = $_ENV['MAIL_PORT'];
  $mail->CharSet    = 'UTF-8';

  // Remetente/Destino
  $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
  $mail->addAddress($_ENV['MAIL_TO']);
  $mail->addReplyTo($email, $nome);

  // Conteúdo
  $mail->isHTML(true);
  $mail->Subject = 'Novo contato no formulário do site';
  $msgEsc = nl2br(htmlspecialchars($mensagem));
  $mail->Body = "
    <h2>Novo contato</h2>
    <p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>
    <p><strong>Telefone:</strong> " . htmlspecialchars($telefone) . "</p>
    <p><strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>
    <p><strong>Mensagem:</strong><br>{$msgEsc}</p>
  ";
  $mail->AltBody = "Nome: {$nome}\nTelefone: {$telefone}\nE-mail: {$email}\nMensagem:\n{$mensagem}";

  $mail->send();

  echo '<h2>Mensagem enviada com sucesso!</h2><p>Obrigado pelo contato.</p><p><a href="/src/index.html">Voltar ao formulário</a></p>';
} catch (Exception $e) {
  http_response_code(500);
  echo '<h2>Erro ao enviar! </h2>';
  echo '<p>' . htmlspecialchars($mail->ErrorInfo) . '</p>';
  echo '<p><a href="/src/index.html">Voltar</a></p>';
}
