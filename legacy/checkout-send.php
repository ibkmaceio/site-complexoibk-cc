<!-- HEADER -->
<?php include "inc/header.php"; ?>

<!-- PHP Mailer -->
<?php

if($_POST['action'] == 'envia_doacao' || $_POST['action'] == 'envia_doacao_secundaria'){
    function gerar_senha($tamanho, $maiuscula, $minuscula, $numeros, $codigos){
        $maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $minus = "abcdefghijklmnopqrstuwxyz";
        $numer = "0123456789";
        $codig = '!@#$%&*()-+.,;?{[}]^><:|';

        $base = '';
        $base .= ($maiuscula) ? $maius : '';
        $base .= ($minuscula) ? $minus : '';
        $base .= ($numeros) ? $numer : '';
        $base .= ($codigos) ? $codig : '';

        srand((float)microtime() * 10000000);
        $senha = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= substr($base, rand(0, strlen($base) - 1), 1);
        }
        return $senha;
    }

    $codificacao_referencia = gerar_senha(5, true, true, true, false);
    $GLOBALS['referencia'] = "REF" . date("dmYHis") . $codificacao_referencia . "";

    global $referencia;

    for ($i=0; $i < sizeof($_POST['tipo']); $i++) {
        $tipo .= $_POST['tipo'][$i].", ";
    }

    $sql = "INSERT INTO _doacoes (
    referencia,
    modalidade,
    tipo,
    forma_entrega,
    cpf,
    nome,
    dt_nascimento,
    email,
    sexo,
    rg,
    tel_cel,
    telefone,
    cep,
    endereco,
    numero,
    complemento,
    bairro,
    cidade,
    estado,
    data
    ) VALUES(
    '".$referencia."',
    '".$_POST['modalidade']."',
    '".$tipo."',
    '".$_POST['forma_entrega']."',
    '".$_POST['cpf']."',
    '".$_POST['nome']."',
    '".$_POST['dt_nascimento']."',
    '".$_POST['email']."',
    '".$_POST['sexo']."',
    '".$_POST['rg']."',
    '".$_POST['tel_cel']."',
    '".$_POST['telefone']."',
    '".$_POST['cep']."',
    '".$_POST['endereco']."',
    '".$_POST['numero']."',
    '".$_POST['complemento']."',
    '".$_POST['bairro']."',
    '".$_POST['cidade']."',
    '".$_POST['estado']."',
    now())";

    if($bd->consulta($sql)){

        $data = date('d/m/Y');
        $acao = str_replace("'","\'", $sql);
        $historico = "INSERT INTO _historico (usuario,data,ip,acao) VALUES ('".$_SESSION['email']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao."')";

        $bd->consulta($historico);
    }

    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";

    // break;

    $nome           = $_POST['nome'];
    $email          = $_POST['email'];
    $tel_cel        = $_POST['tel_cel'];
    $modalidade     = $_POST['modalidade'];

    for ($i=0; $i < sizeof($_POST['tipo']); $i++) {
        $tipo_final .= $_POST['tipo'][$i].", ";
    }

    $tipo           = $tipo_final;

    if ($_POST['forma_entrega'] == "Venham") {
        $forma_entrega_final = "Venham Buscar";
    } else {
        $forma_entrega_final = "Irei Levar";
    }

    $forma_entrega  = $forma_entrega_final;
    $cep            = $_POST['cep'];
    $endereco       = $_POST['endereco'];
    $numero         = $_POST['numero'];
    $complemento    = $_POST['complemento'];
    $bairro         = $_POST['bairro'];
    $cidade         = $_POST['cidade'];
    $estado         = $_POST['estado'];
    $assunto        = "Doação para IBK";

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
                        '.$nome.' <strong>&bull; '.$email.'</strong><br>
                        Telefone: <strong>'.$tel_cel.'</strong><br>
                        Assunto do email: <strong>'.$assunto.'</strong><br>
                        -<br>
                        Modalidade: <strong>'.$modalidade.'</strong><br>
                        Tipo de Doação: <strong>'.$tipo_final.'</strong><br>
                        Forma de Entrega: <strong>'.$forma_entrega_final.'</strong><br>
                        -<br>

                        CEP: <strong>'.$cep.'</strong><br>
                        Endereco: <strong>'.$endereco.'</strong>, <strong>'.$numero.'</strong><br>
                        Complemento: <strong>'.$complemento.'</strong><br>
                        <strong>'.$bairro.'</strong>, <strong>'.$cidade.'</strong>/<strong>'.$estado.'</strong>
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
        echo '<script type="text/javascript">alert("Os dados da sua Doação foram enviados para nossa equipe. Aguarde nosso contato!");</script>';
        echo "<meta http-equiv='refresh' content='0;URL=/'>";
    }
}
?>

<?php include "inc/footer.php"; ?>