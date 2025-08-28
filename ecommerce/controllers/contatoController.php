<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script src="../functions/templates.js" type="module"></script>';

require '../vendor/autoload.php';

class ContatoController {
    
    public function enviarEmailContato() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $mensagem = isset($_POST['mensagem']) ? trim($_POST['mensagem']) : null;

            // Validação básica dos campos
            if (empty($nome) || empty($email) || empty($mensagem)) {
                echo '<script type="module">
                import {errorGeral} from "../functions/templates.js";
                errorGeral("Por favor, preencha todos os campos!");
                </script>';
                return;
            }

            // Enviar o e-mail usando o PHPMailer
            if ($this->enviarEmail($nome, $email, $mensagem)) {
                echo '<script type="module">
                import {sucessoGeral} from "../functions/templates.js";
                sucessoGeral("E-mail enviado com sucesso!");
                </script>';
            } else {
                echo '<script type="module">
                import {errorGeral} from "../functions/templates.js";
                errorGeral("Falha ao enviar e-mail");
                </script>';
            }
        }
    }

    private function enviarEmail($nome, $email, $mensagem) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admgeral0191@gmail.com';
            $mail->Password   = 'gypf rtdq tfvu ncwb';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Remetente e destinatário
            $mail->setFrom('seuemail@gmail.com', 'OneClick Store');
            $mail->addAddress('oneclickstorecontato431287@gmail.com'); // Email de destino

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Nova mensagem de contato';
            $mail->Body    = "Nome: $nome <br>Email: $email <br>Mensagem: $mensagem";
            $mail->AltBody = "Nome: $nome\nEmail: $email\nMensagem: $mensagem";

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo '<script type="module">
                import {errorGeral} from "../functions/templates.js";
                errorGeral('.error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");');
                </script>';
            return false;
        }
    }
}

// Instancia o controlador e chama o método de envio
$contatoController = new ContatoController();
$contatoController->enviarEmailContato();

