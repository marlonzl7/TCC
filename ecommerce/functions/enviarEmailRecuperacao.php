<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function enviarEmailRecuperacao($email, $linkRecuperacao) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                   
        $mail->SMTPAuth   = true;                            
        $mail->Username   = '';     // Usuário removido            
        $mail->Password   = '';     // Senha removida  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
        $mail->Port       = 587;                                 

        $mail->setFrom('seuemail@gmail.com', 'OneClick Store');
        $mail->addAddress($email);                              

        $mail->isHTML(true);                                 
        $mail->Subject = 'Recuperação de Senha';
        $mail->Body    = "Acesse o link <a href='$linkRecuperacao'> para redefinir sua senha.";
        $mail->AltBody = "Acesse o link <a href='$linkRecuperacao'> para redefinir sua senha.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "<script>alert('Falha ao enviar e-mail. Erro: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
