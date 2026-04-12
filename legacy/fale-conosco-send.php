<!-- HEADER -->
<?php include "inc/header.php"; ?>

<!-- PHP Mailer -->
<?php

if($_POST['action'] == 'envia_contato'){

    $sql = "INSERT INTO _contatos (
    nome,
    email,
    telefone,
    assunto,
    texto,
    data_contato
    ) VALUES(
    '".$_POST['nome']."',
    '".$_POST['email']."',
    '".$_POST['telefone']."',
    '".$_POST['assunto']."',
    '".$_POST['texto']."',
    now())";

    if($bd->consulta($sql)){

        $data = date('d/m/Y');
        $acao = str_replace("'","\'", $sql);
        $historico = "INSERT INTO _historico (usuario,data,ip,acao) VALUES ('".$_SESSION['email']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao."')";

        $bd->consulta($historico);
    }

    $nome       = $_POST['nome'];
    $email      = $_POST['email'];
    $telefone   = $_POST['telefone'];
    $texto      = $_POST['texto'];
    $assunto    = $_POST['assunto'];

    require ($_SERVER['DOCUMENT_ROOT']."/cms/phpMailer/PHPMailerAutoload.php");

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                                                     // Enable verbose debug output

    $mail->isSMTP();                                                            // Set mailer to use SMTP
    $mail->SMTPAuth     = true;                                                 // Enable SMTP authentication
    $mail->SMTPSecure   = false;                                                // Enable TLS encryption, `ssl` also accepted
    $mail->Port         = 587;                                                  // TCP port to connect to
    $mail->Host         = 'smtp.gmail.com';                                     // Specify main and backup SMTP servers
    $mail->Username     = 'suporte@rota3.com.br';                               // SMTP username
    $mail->Password     = 'padrao321';                                          // SMTP password

    $mail->setFrom('suporte@rota3.com.br', 'Igreja Batista Koinonia');
    $mail->addAddress("$email", "$nome");                                        // Add a recipient
    $mail->addReplyTo("$email", "$nome");                                        // Add a recipient
    $mail->addCC('contato@ibkmaceio.com.br', 'Igreja Batista Koinonia');
    $mail->addBCC('iuriivooliveira@gmail.com', 'Igreja Batista Koinonia');
    $mail->addBCC('fale@rota3.com.br', 'Rota 3 Agencia Full');

    // $mail->addAttachment('/var/tmp/file.tar.gz');                             // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');                        // Optional name
    $mail->isHTML(true);                                                         // Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $assunto;
    $mail->Body    =
    '
    <body style="background: #f1f2f7;color: #333; padding:20px 0; font-family: arial; font-size:12px;">
        <table border="0" style="margin:0 auto; width:700px; background-color: #fff; font-size: 12px; padding:40px;">
            <tr>
                <td width="60%">
                    <span style="font-size:21px; letter-spacing:-1px; color:#FF007F">Olá '.$nome.'!</span>
                    <p style="line-height:1.7; margin-top:0;">Agradecemos por entrar em contato conosco. Foi enviada uma mensagem através do nosso site.</p>
                    <p style="line-height:1.7;">Seguem abaixo os dados da mensagem: </p>

                    <hr style="border-bottom:1px dotted #ccc; border-top:1px solid transparent;">

                    <span style="line-height:1.5">
                        '.$nome.' &bull; '.$email.'<br>
                        Telefone: <strong>'.$telefone.'</strong><br>
                        Assunto do email: <strong>'.$assunto.'</strong><br>
                        -<br>
                        Mensagem: <br>
                        '.$texto.'
                    </span>
                </td>
                <td width="40%"><img src="http://res.cloudinary.com/rota-3/image/upload/v1487943880/message_kjzzbz.png" width="100%"></td>
            </tr>
            <tr>
                <td></td>
                <td style="color: #ccc; text-align: right;">Email enviado por <a href="http://www.rota3.com.br" target="_blank" rel="noopener noreferrer" style="color: #93c54b;">www.rota3.com.br</a></td>
            </tr>
        </table>
    </body>
    ';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo '<script type="text/javascript">alert("Erro! Tente novamente mais tarde.");</script>';
        echo "<meta http-equiv='refresh' content='0;URL=/'>";
        echo $mail->ErrorInfo;
    } else {
        echo '<script type="text/javascript">alert("Envio realizado com sucesso! Em breve entraremos em contato!");</script>';
        echo "<meta http-equiv='refresh' content='0;URL=/'>";
    }
}
?>

<?php include "inc/footer.php"; ?>