<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function enviarEmailRecuperacao($email, $linkRecuperacao) {
    $mail = new PHPMailer(true); // Instancia o PHPMailer

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();                                          // Defina o uso do SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Endereço do servidor SMTP
        $mail->SMTPAuth   = true;                                // Ativa a autenticação SMTP
        $mail->Username   = 'admgeral0191@gmail.com';                // Seu e-mail do Gmail
        $mail->Password   = 'gypf rtdq tfvu ncwb';                   // Senha de aplicativo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Habilita criptografia TLS
        $mail->Port       = 587;                                 // Porta TCP para conexão

        // Remetente e destinatário
        $mail->setFrom('seuemail@gmail.com', 'OneClick Store');
        $mail->addAddress($email);                              // Adiciona o destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);                                  // Define o formato de e-mail como HTML
        $mail->Subject = 'Recuperação de Senha';
        $mail->Body    = "Acesse o link <a href='$linkRecuperacao'> para redefinir sua senha.";
        $mail->AltBody = "Acesse o link <a href='$linkRecuperacao'> para redefinir sua senha.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "<script>alert('Falha ao enviar e-mail. Erro: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
