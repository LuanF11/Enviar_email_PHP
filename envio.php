<?php

// Biblioteca PHPMailer
require './bibliotecas/PHPMailer/PHPMailer.php';
require './bibliotecas/PHPMailer/POP3.php';
require './bibliotecas/PHPMailer/Exception.php';
require './bibliotecas/PHPMailer/SMTP.php';
require './bibliotecas/PHPMailer/OAuth.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// print_r($_POST);

// Classe que recebe as informações sobre o email
class Mensagem
{

    private $destino = null;
    private $assunto = null;
    private $mensagem = null;
    public $status = array('id' => null, 'descricao' => '');

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


if (!$mensagem->envioValido()) {

    echo 'mensagem invalida';
    header('Location:index.php');
    die();
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = false;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tenvio45@gmail.com';                     //SMTP username
    $mail->Password   = 'ctetbrnskhxxtior';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('tenvio45@gmail.com', 'teste envio');
    $mail->addAddress($mensagem->__get('destino'));     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'Mensagem';

    $mail->send();

    $mensagem->status['id'] = 1;
    $mensagem->status['descricao'] = "Email enviado";
} catch (Exception $e) {

    $mensagem->status['id'] = 2;
    $mensagem->status['descricao'] = "Informacao do erro. Mailer Error: {$mail->ErrorInfo}";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php if ($mensagem->status['id'] == 1) {
                ?>

                    <div class="container">
                        <h1 class="display-2 text-sucess">Enviado</h1>
                        <p><?php echo $mensagem->status['descricao']
                            ?>
                            <a href="index.php" class="btn btn-primary btn-lg">Voltar</a>

                        </p>
                    </div>

                <?php } ?>

                <?php if ($mensagem->status['id'] == 2) {
                ?>

                    <div class="container">
                        <h1 class="display-2 text-danger">Não Enviado</h1>
                        <p><?php echo $mensagem->status['descricao']
                            ?>
                            <a href="index.php" class="btn btn-secondary btn-lg">Voltar</a>

                        </p>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>

</body>

</html>