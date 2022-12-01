<?php

// Biblioteca PHPMailer
require './bibliotecas/PHPMailer/PHPMailer.php';
require './bibliotecas/PHPMailer/POP3.php';
require './bibliotecas/PHPMailer/Exception.php';
require './bibliotecas/PHPMailer/SMTP.php';
require './bibliotecas/PHPMailer/OAuth.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


print_r($_POST);

// Classe que recebe as informações sobre o email
class Mensagem
{

    private $destino = null;
    private $assunto = null;
    private $mensagem = null;

    public function __construct($destino, $assunto, $mensagem)
    {

        $this->destino = $destino;
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
    }


    public function __get($name)
    {

        return $this->$name;
    }

    public function __set($name, $value)
    {

        $this->$name = $value;
    }

    public function envioValido()
    {

        if (empty($this->destino) || empty($this->assunto) || empty($this->mensagem)) {

            return false;
        }

        return true;
    }
}

$mensagem = new Mensagem($_POST['destino'], $_POST['assunto'], $_POST['mensagem']);

// $mensagem->__set('destino', $_POST['destino']);
// $mensagem->__set('assunto', $_POST['assunto']);
// $mensagem->__set('mensagem', $_POST['mensagem']);

// print_r($email);

if (!$mensagem->envioValido()) {

    echo 'mensagem invalida';
    die();
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tenvio45@gmail.com';                     //SMTP username
    $mail->Password   = 'ctetbrnskhxxtior';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('tenvio45@gmail.com', 'teste envio');
    $mail->addAddress('luan.alves06@aluno.ifce.edu.br', 'destino teste envio');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Assunto';
    $mail->Body    = '<strong>corpo</strong>';
    $mail->AltBody = 'corpo';

    $mail->send();
    echo 'Email enviado';
} catch (Exception $e) {
    echo "Informacao do erro. Mailer Error: {$mail->ErrorInfo}";
}
