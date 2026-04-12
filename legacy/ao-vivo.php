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

if ($_SERVER['SERVER_NAME'] == "ibkmaceio.rota3.com.br") { $baseURL = ""; }
elseif  ($_SERVER['SERVER_NAME'] != "ibkmaceio.rota3.com.br") { $baseURL = ""; }
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

$sql_live = mysql_query("SELECT * FROM _videos WHERE ativo ='S' AND ao_vivo = 'S' ORDER BY id DESC ");
while ($dados_live = mysql_fetch_array($sql_live)) {

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <base href="/">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Transmissão AO VIVO IBK</title>

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

    <link rel="shortcut icon" href="assets/img/rec.gif">
    <link rel="shortcut icon" href="assets/img/rec.gif" type="image.gif">

    <link href='https://fonts.googleapis.com/css?family=Galindo' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- SHARE SOCIAL -->
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />

</head>
<body>
    <style>
        a {text-decoration: none;}
        a:focus {text-decoration: none;}
    </style>

    <div id="opacidade"></div>

    <section class="title-int" style="background: #222; padding-top: 20px;">
        <div class="container" style="padding-bottom:0;">
            <div class="row">
                <div class="col-sm-12 tira-padding-right tira-padding-left">
                    <div class="title-int-text">
                        <h1 class="pull-left">
                            <div class="btn-ao-vivo">
                                <a href="javascript:void();" class="active"><i class="fa fa-circle"></i> Transmissão AO VIVO  <i class="fas fa-angle-right"></i> <span><?php echo $dados_live['titulo']; ?></span></a>
                            </div>
                        </h1>

                        <div class="col-sm-3 pull-right text-right tira-padding-right icon-ao-vivo">
                            <a href="tv-ibk" class="share-is" uk-tooltip="title: Voltar; pos: top-left"><i class="fas fa-home"></i></a>

                            <a href="#modal-share" uk-toggle class="share-is" uk-tooltip="title: Compartilhe nas redes; pos: top-left"><i class="fas fa-share-alt"></i></a>
                            <a href="javascript:void();" id="btn-luz"><i class="fas fa-lightbulb"></i> <span class="apagar-acender">Apagar a Luz</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="colors" style="background: transparent; top: -9px; z-index: 0;">
        <div class="container">
            <div class="row">
                <div class="cor1"></div>
                <div class="cor2"></div>
                <div class="cor3"></div>
            </div>
        </div>
    </section>

    <div id="live">
        <iframe width="100%" class="video_institucional" style="margin-top: -10px;" src="https://www.youtube.com/embed/<?php echo $dados_live['embed']; ?>?&autoplay=1" frameborder="0" allow="encrypted-media" autoplay allowfullscreen></iframe>
    </div>

    <div id="modal-share" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <h1>Compartilhe essa transmissão com seus amigos e familiares</h1>
            <p>Clique na rede social desejada para compartilhar</p>
            <hr>
            <div id="shareIcons" class="jssocials" style="font-size: 18px;"></div>

        </div>
    </div>

<?php $bd->next(); } ?>

<?php include "inc/footer.php"; ?>

<script type="text/javascript">
        $('#opacidade').css('height', $(document).height()).hide();
        $('a#btn-luz').click(function() {
            $('#opacidade').toggle();
            if ($('#opacidade').is(':hidden')) {
                $('span.apagar-acender').html('Apagar a luz');
            } else {
                $('span.apagar-acender').html('Acender a luz');
            }
        });
</script>