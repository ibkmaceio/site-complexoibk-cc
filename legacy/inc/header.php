<?php

/* ===================================================
 * v3.0
 * http://rota3.com.br/cms
 * ===================================================
 * Copyright 2014 Rota3, Inc.
 *
 * Rota 3 Agencia Full
 * CMS v3.0
 * Ultima Modificacao
 * 15/10/2018 - Ederson Rodrigues { IMPLEMENTACAO NO SITE }
 * 03/11/2018 - Ederson Rodrigues { IMPLEMENTACAO DA VERIFICACAO DO SOMINIO LOCAL E REMOTO }
 *
 * CMS Rota 3
 * limitations under the License.
 * ===================================================
*/

if ($_SERVER['SERVER_NAME'] == "ibkmaceio.com.br") { $baseURL = ""; }
elseif  ($_SERVER['SERVER_NAME'] != "ibkmaceio.com.br") { $baseURL = ""; }
else { echo "Nenhum modelo de BASEURL selecionado"; }

include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/config.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeSGBD.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeDb.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/data.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/function.php");

// CONECTAR NO BANCO DE DADOS DA ROTA
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

date_default_timezone_set("Brazil/East");

// CHAMADAS
$sql_H_Footer = mysql_query("SELECT * FROM _configuracoes WHERE ativo = 'S' ORDER BY id DESC");
$dados_H_Footer = mysql_fetch_array($sql_H_Footer);
?>

<?php

// PHP Mailer
if($_POST['action'] == 'cadNewsletter'){

    $sql = "INSERT INTO _newsletter (
    nome,
    email,
    data
    ) VALUES(
    '".$_POST['nome']."',
    '".$_POST['email']."',
    now())";

    if($bd->consulta($sql)){

        $data = date('d/m/Y');
        $acao = str_replace("'","\'", $sql);
        $historico = "INSERT INTO _historico (usuario,data,ip,acao) VALUES ('".$_SESSION['email']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao."')";

        $bd->consulta($historico);
    }

    $nome       = $_POST['nome'];
    $email      = $_POST['email'];
    $assunto    = "Cadastro IBK Mailling";

    require ($_SERVER['DOCUMENT_ROOT']."/cms/phpMailer/PHPMailerAutoload.php");

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                                                     // Enable verbose debug output
    $mail->isSMTP();                                                            // Set mailer to use SMTP
    $mail->SMTPAuth = true;                                                     // Enable SMTP authentication
    $mail->SMTPSecure = false;                                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                                          // TCP port to connect to
    $mail->Host = 'smtp.gmail.com';                                             // Specify main and backup SMTP servers
    $mail->Username = 'suporte@rota3.com.br';                                   // SMTP username
    $mail->Password = 'padrao321';                                              // SMTP password

    $mail->setFrom('suporte@rota3.com.br', 'IBK Maceió');
    $mail->addAddress("$email", "$nome");                                        // Add a recipient
    $mail->addReplyTo("$email", "$nome");                                        // Add a recipient
    $mail->addCC('contato@ibkmaceio.com.br', 'IBK Maceió');
    $mail->addBCC('iuriivooliveira@gmail.com', 'IBK Maceió');
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
                    <p style="line-height:1.7; margin-top:0;">Agradecemos por entrar em nossa base de dados. Foi enviada uma mensagem através do nosso site.</p><br>
                    <hr style="border-bottom:1px dotted #ccc; border-top:1px solid transparent;">

                    <span style="line-height:1.5">
                        '.$nome.' &bull; '.$email.'<br>
                    </span>
                </td>
            </tr>
            <tr>
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
        echo '<script type="text/javascript">alert("Cadastro realizado com sucesso! Seja bem vindo!");</script>';
        echo "<meta http-equiv='refresh' content='0;URL=/'>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<!-- BASE URL -->
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="generator" content="Rota 3 Agencia Full - www.rota3.com.br" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="1 DAYS">
    <meta name="language" content="pt-br">
    <meta name="identifier-URL" content="http://<?php echo $dados_H_Footer['site'];?>">
    <meta name="category" content="Church">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="copyright" content="http://<?php echo $dados_H_Footer['_site_titulo'];?>">
    <meta content="pt-br" http-equiv="Content-Language">
    <link rel="author" type="text/plain" href="http://<?php echo $dados_H_Footer['site'];?>/humans.txt" />
    <link rel="alternate" href="http://<?php echo $dados_H_Footer['site'];?>" hreflang="pt-br" />
    <link rel="canonical" href="http://<?php echo $dados_H_Footer['site'];?>" />
    <link rel="index" href="http://<?php echo $dados_H_Footer['site'];?>">
    <link rel="icon" type="image/png" href="assets/img/icon.png" />

    <meta name="keywords" content="<?php $sql_tag = mysql_query("SELECT * FROM _tags ORDER BY id DESC"); while ($dados_tag = mysql_fetch_array($sql_tag)) {echo $dados_tag['tag'] . ", "; }?>">
    <?php
        if($_SERVER['PHP_SELF'] == '/novidades-view.php'){
        $sql_titulos = mysql_query(" SELECT * FROM _noticias where slug = '".$_GET['slug']."' ");
        $dadosTitulo = mysql_fetch_array($sql_titulos);
    ?>
    <link rel="canonical" href="http://ibkmaceio.com.br/novidades/<?php echo $dadosTitulo['categoria_noticia_slug']; ?>/<?php echo $dadosTitulo['titulo_apelido']; ?>" />
    <meta name="description" content="<?php echo $dados_H_Footer['_site_descricao']; ?>">
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $dadosTitulo['titulo']; ?> - <?php echo $dados_H_Footer['_site_titulo']; ?>" />
    <meta property="og:description" content="<?php echo $dadosTitulo['titulo_breve']; ?>" />
    <meta property="og:url" content="http://ibkmaceio.com.br/novidades/<?php echo $dadosTitulo['categoria_noticia_slug']; ?>/<?php echo $dadosTitulo['titulo_apelido']; ?>" />
    <meta property="og:site_name" content="<?php echo $dados_H_Footer['_site_titulo']; ?>" />
    <meta property="article:publisher" content="<?php echo $dados_H_Footer['_site_titulo']; ?>" />
    <meta property="article:author" content="<?php echo $dadosTitulo['autor']; ?>" />
    <meta property="article:section" content="Noticias" />
    <meta property="og:image" content="http://<?php echo $dados_H_Footer['site'];?>/cms/assets/uploads/_NOTICIAS/<?php echo $dadosTitulo['img'];?>" />

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="<?php echo $dadosTitulo['titulo_breve']; ?>"/>
    <meta name="twitter:title" content="<?php echo $dadosTitulo['titulo']; ?> - <?php echo $dados_H_Footer['_site_titulo']; ?>"/>
    <meta name="twitter:site" content="<?php echo $dados_H_Footer['_site_titulo']; ?>"/>
    <meta name="twitter:domain" content="<?php echo $dados_H_Footer['site']; ?>"/>
    <meta name="twitter:image" content="http://<?php echo $dados_H_Footer['site'];?>/cms/assets/uploads/_NOTICIAS/<?php echo $dadosTitulo['img'];?>"/>
    <meta name="twitter:creator" content="@rota3full"/>

    <title><?php echo $dadosTitulo['titulo']; ?> - <?php echo $dados_H_Footer['_site_titulo']; ?></title>

    <?php }else {?>

    <meta property="busca:publisher" content="<?php echo $dados_H_Footer['_site_titulo']; ?>" />
    <meta property="busca:title" content="<?php echo $dados_H_Footer['_site_titulo']; ?>"/>
    <meta property="busca:species" content="Igreja" />

    <meta itemprop="headline" content="<?php echo $dados_H_Footer['_site_titulo']; ?> - <?php echo $dados_H_Footer['_site_descricao']; ?>"/>
    <meta itemprop="url" content="http://<?php echo $dados_H_Footer['site'];?>"/>
    <meta itemprop="image" content="http://<?php echo $dados_H_Footer['site'];?>/assets/img/logo.png"/>
    <meta itemprop="description" content="<?php echo $dados_H_Footer['_site_titulo']; ?> - <?php echo $dados_H_Footer['_site_descricao']; ?>"/>

    <meta name="og:title" content="<?php echo $dados_H_Footer['_site_titulo']; ?>"/>
    <meta name="og:type" content="site"/>
    <meta name="og:url" content="http://<?php echo $dados_H_Footer['site'];?>"/>
    <meta name="og:image" content="https://<?php echo $dados_H_Footer['site'];?>/assets/img/logo.png"/>
    <meta name="og:site_name" content="<?php echo $dados_H_Footer['_site_titulo']; ?>"/>
    <meta name="og:description" content="<?php echo $dados_H_Footer['_site_descricao']; ?>"/>

    <title><?php echo $dados_H_Footer['_site_titulo']; ?> - <?php echo $dados_H_Footer['_site_descricao']; ?></title>
    <?php } ?>

    <!-- Imports css bower-->
    <link rel="stylesheet" href="assets/css/uikit.css">
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/bower_components/bxSlider/dist/jquery.bxslider.css">
    <link rel="stylesheet" href="assets/bower_components/ekko-lightbox/dist/ekko-lightbox.css">

    <!-- Imports css estilos -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/interna.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/global.css">

    <!-- EVENTOS -->
    <link rel="stylesheet" href="assets/css/pignose.calendar.css">

    <!-- AUTO COMPLETE SEARCH -->
    <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.16/themes/black-tie/jquery-ui.css">

    <!-- SHARE SOCIAL -->
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />

    <link href='https://fonts.googleapis.com/css?family=Galindo' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

    <!-- Maps API Javascript -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD14vEEjTD8GGoVs6RKc_gZSnYBojJQEjw"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-47992049-60"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-47992049-60');
    </script>


</head>
<body>

    <header>
        <div class="container">
            <div class="row">
                <div class="top">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a href="/">
                            <div class="logo">
                                <img src="assets/img/logo-header.png" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12"></div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                        <div class="info-contato-header">
                            <h6><button uk-toggle="target: #offcanvas-push"><i class="fa fa-edit"></i> Assine nossa newsletter</button></h6>
                            <h6><i class="fas fa-envelope-open-text"></i> <?php echo $dados_H_Footer['email'] ?> <span style="margin-left: 20px;"><i class="fa fa-phone"></i> <?php echo $dados_H_Footer['telefone'] ?></span></h6>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="social-header">
                            <ul>
                                <?php if ($dados_H_Footer['facebook'] == "") {} else { ?>
                                    <li><a href="http://facebook.com/<?php echo $dados_H_Footer['facebook'];?>" target="_blank" rel="noopener noreferrer"><i class='fab fa-facebook-square'></i></a></li>
                                <?php } ?>

                                <?php if ($dados_H_Footer['instagram'] == "") {} else { ?>
                                    <li><a href="http://instagram.com/<?php echo $dados_H_Footer['instagram'];?>" target="_blank" rel="noopener noreferrer"><i class='fab fa-instagram'></i></a></li>
                                <?php } ?>

                                <?php if ($dados_H_Footer['linkedin'] == "") {} else { ?>
                                    <li><a href="http://linkedin.com/user/<?php echo $dados_H_Footer['linkedin'];?>" target="_blank" rel="noopener noreferrer"><i class='fa fa-linkedin'></i></a></li>
                                <?php } ?>

                                <?php if ($dados_H_Footer['twitter'] == "") {} else { ?>
                                    <li><a href="http://twitter.com/<?php echo $dados_H_Footer['twitter'];?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter"></i></a></li>
                                <?php } ?>

                                <?php if ($dados_H_Footer['youtube'] == "") {} else { ?>
                                    <li><a href="http://youtube.com/<?php echo $dados_H_Footer['youtube'];?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>
                                <?php } ?>

                                <?php if ($dados_H_Footer['whatsapp'] == "") {} else { ?>
                                    <li><a href="https://api.whatsapp.com/send?phone=<?php echo $dados_H_Footer['whatsapp'];?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-whatsapp"></i></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" uk-sticky="offset:2">
                        <ul class="nav navbar-nav">
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/index.php") echo "active"; ?>" href="/">Início</a></li>
                            <li class="dropdown drop-desktop">
                                <a href="" class="<?php if($_SERVER['PHP_SELF'] == "/ministerios-view.php") echo "active"; ?> dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sobre a Koinonia <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="menu-full">
                                        <ul class="menu-hori">
                                            <h4>Institucional</h4>
                                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/institucional.php") echo "active"; ?>" href="institucional/sobre-a-ibk">Sobre nós</a></li>
                                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/nossa-historia.php") echo "active"; ?>" href="institucional/nossa-historia">Nossa História</a></li>
                                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/liderancas.php") echo "active"; ?>" href="institucional/liderancas">Lideranças</a></li>
                                        </ul>
                                        <ul class="menu-hori menu-hori-2">
                                            <h4>Ministérios</h4>

                                            <?php
                                            $sql_car_menu = "SELECT * FROM _ministerios_categoria WHERE ativo = 'S' ORDER BY titulo ASC";
                                            $lista = mysql_query($sql_car_menu);
                                            while($dados_car_menu = mysql_fetch_array($lista)):
                                            ?>
                                            <div style="line-height: 1.6; float: left; width: 170px;">
                                                <li><a href="ministerios/<?php echo $dados_car_menu['slug']; ?>"><?php echo $dados_car_menu['titulo']; ?></a></li>
                                            </div>
                                            <?php endwhile ?>
                                        </ul>

                                        <!-- <ul class="menu-hori">
                                            <h4>Ministérios</h4>
                                            <li><a href="ministerios">EBD</a></li>
                                            <li><a href="ministerios">Juventude e Adolencentes</a></li>
                                            <li><a href="ministerios">Casais Koinonia</a></li>
                                            <li><a href="ministerios">Diretoria</a></li>
                                            <li><a href="ministerios">Administração</a></li>
                                            <li><a href="ministerios">Teatro Konsagrarte</a></li>
                                        </ul> -->
                                        <!-- <ul class="menu-hori">
                                            <h4>&nbsp;</h4>
                                            <li><a href="ministerios">Coral</a></li>
                                            <li><a href="ministerios">Comunicação</a></li>
                                            <li><a href="ministerios">Eclésia</a></li>
                                            <li><a href="ministerios">Louvor e Adoração</a></li>
                                            <li><a href="ministerios">Voluntários</a></li>
                                            <li><a href="ministerios">Comunhão</a></li>
                                        </ul>
                                        <ul class="menu-hori">
                                            <h4>&nbsp;</h4>
                                            <li><a href="ministerios">Integração</a></li>
                                            <li><a href="ministerios">Koinonia Kids</a></li>
                                            <li><a href="ministerios">Koinonia com Surdos</a></li>
                                            <li><a href="ministerios">Esportes</a></li>
                                            <li><a href="ministerios">Ornamentação</a></li>
                                        </ul> -->
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown drop-mobile">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sobre a Koinonia <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="institucional/sobre-a-ibk">Sobre nós</a></li>
                                    <li><a href="institucional/nossa-historia">Nossa História</a></li>
                                    <li><a href="institucional/liderancas">Lideranças</a></li>

                                    <?php
                                    $sql_car_menu_2 = "SELECT * FROM _ministerios_categoria WHERE ativo = 'S' ORDER BY titulo ASC";
                                    $lista = mysql_query($sql_car_menu_2);

                                    while($dados_car_menu_2 = mysql_fetch_array($lista)):
                                    ?>
                                    <li><a href="ministerios/<?php echo $dados_car_menu_2['slug']; ?>"><?php echo $dados_car_menu_2['titulo']; ?></a></li>
                                    <?php endwhile ?>
                                </ul>
                            </li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/nossos-eventos.php") echo "active"; ?>" href="nossos-eventos">Eventos</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/novidades.php") echo "active"; ?>" href="novidades">Conteúdo & Novidades</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/podcasts.php") echo "active"; ?>" href="podcasts">Podcasts</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/midia.php" || $_SERVER['PHP_SELF'] == "/midia-view.php") echo "active"; ?>" href="midia">Mídia</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/tv-ibk.php") echo "active"; ?>" href="tv-ibk">TV IBK</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/checkout.php") echo "active"; ?>" href="doacoes">Doações</a></li>
                            <li><a class="<?php if($_SERVER['PHP_SELF'] == "/fale-conosco.php") echo "active"; ?>" href="entre-em-contato">Entre em Contato</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div><!-- /.container-fluid -->
        </div>
    </header>

    <div class="totop1">
        <div id="totop" uk-sticky="top: #totop1; bottom: #bottomF; offset: 600;">
            <a href="javascript:void();" uk-scroll uk-tooltip="title: Subir; pos: top-left" class="totop-2">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
