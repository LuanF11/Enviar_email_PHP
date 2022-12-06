# Projeto para envio de e-mail com PHP!

Este projeto tem como objetivo testar conhecimentos em **PHP**,  com a ideia de pegar ao muito utilizado e tentar implementar com uma interface simples de ser usada.


# Arquivos

- Diretório - **Enviar_email_PHP** está presente todos os arquivos.
- Bibliotecas - Contém as bibliotecas usadas
>A biblioteca utilizada foi a **PHPMailer**
- **Envio.php** - Responsável por todo o recebimento e processamento dos dados para serem enviados
- **Index.php** - Contém a interface para inserir os dados do email e envia-los para o processamento

## Ponto importante

Para o envio do e-mail deve ser informado no arquivo **Envio.php** o e-mail que ira enviar as mensagens e a chave Smtp:

|     Linha           |Código                        |Dados                       |
|----------------|-------------------------------|-----------------------------|
|80|   $mail->Username  =       |'Insira o e-mail de origem'            |
|81         |$mail->Password  =             |"Insira a chave smtp"           



## Gerar chave Smtp

Para gerar a chave Smtp deve primeiro ativar a **verificação por duas etapas**, para isso deve ir nas **Configurações**, **Segurança**, depois ativada a verificação. Em seguida permitir o acesso para aplicativos menos seguros e pegar a chave que será gerada e inserir na linha 81.