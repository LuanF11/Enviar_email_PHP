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
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
