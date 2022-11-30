<?php
print_r($_POST);


class Email
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

$email = new Email($_POST['destino'], $_POST['assunto'], $_POST['mensagem']);

// $mensagem->__set('destino', $_POST['destino']);
// $mensagem->__set('assunto', $_POST['assunto']);
// $mensagem->__set('mensagem', $_POST['mensagem']);

// print_r($email);

if ($email->envioValido()) {

    echo 'mensagem valida';
} else {

    echo 'mensagem não valida';
}
