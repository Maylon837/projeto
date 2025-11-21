<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; 

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

include("conexao.php"); 

$sql = "SELECT email, nome, sobrenome FROM cadastros WHERE newsletter_ativo = 1";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    
    $mail = new PHPMailer(true); 
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';   
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seuemail@exemplo.com'; 
        $mail->Password   = 'sua_senha_de_app_ou_smtp'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port       = 465; 
        $mail->CharSet    = 'UTF-8'; 
        
        $mail->setFrom('seuemail@exemplo.com', 'CM ESG - Atualizações'); 
        $mail->isHTML(true);
        $mail->Subject = 'Nova Atualização Importante do Nosso Site!';
        
        $emails_enviados = 0;
        
        while($usuario = $resultado->fetch_assoc()) {
            $destinatario_email = $usuario['email'];
            $destinatario_nome = $usuario['nome'];
            
            $mail->clearAllRecipients(); 
            $mail->addAddress($destinatario_email, $destinatario_nome);
            
            $corpo_email = "Olá {$destinatario_nome},<br><br>";
            $corpo_email .= "
                <h1>🎉 Temos Novidades!</h1>
                <p>Nesta semana, lançamos uma nova seção de relatórios de impacto ambiental detalhados. 
                Agora você pode acompanhar as métricas em tempo real e baixar PDFs otimizados para apresentação.</p>
                <p>Acesse o nosso site para conferir todas as melhorias!</p>
                <p style='margin-top: 20px;'>
                    <a href='http://seusite.com/novidades' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Ver Novidades</a>
                </p>
                <br>
            ";
            $corpo_email .= "<br><br>Atenciosamente,<br>A Equipe CM ESG.";
            
            $mail->Body = $corpo_email;
            
            $mail->send();
            $emails_enviados++;
        }
        
        echo "Newsletter enviada com sucesso para " . $emails_enviados . " usuários!";

    } catch (Exception $e) {
        echo "Erro ao enviar a Newsletter. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Nenhum usuário ativo para a Newsletter.";
}

if (isset($conn)) {
    $conn->close();
}
?>