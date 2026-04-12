<?php
/* ===================================================
 * CMS - Gestor de Conteudo
 * ===================================================
 * Copyright 2017 Rota3, Inc.
 *
 * Rota 3 Agencia Full
 * CMS v4.0
 *
 * limitations under the License.
 * ===================================================
*/

session_start();

// VERIFICACAO DO DOMINIO
if ($_SERVER['SERVER_NAME'] == "ibkmaceio.com.br") { $baseURL = "/cms/"; }
elseif  ($_SERVER['SERVER_NAME'] != "ibkmaceio.com.br/cms") { $baseURL = "/"; }
else { echo "Nenhum modelo de BASEURL selecionado"; }

include ($_SERVER['DOCUMENT_ROOT'].$baseURL."./config/config.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."./config/classeSGBD.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."./config/classeDb.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."./config/data.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."./config/function.php");

// Chamada do Banco de dados
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

// if session is not set redirect the user
if(empty($_SESSION['nome']))
    header("Location: login");

//if logout then destroy the session and redirect the user
if(isset($_GET['logout']))
{
    session_destroy();
    header("Location: login");
}

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

date_default_timezone_set("Brazil/East");

// CHAMADAS
$sql_config = mysql_query("SELECT * FROM _configuracoes WHERE ativo = 'S' order by id DESC");
$dados_config = mysql_fetch_array($sql_config);
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">

    <base href="<?php echo $baseURL; ?>">
    <title>Gestão de Conteúdo - Rota 3 Brasil</title>

    <!-- ICON -->
    <link rel="icon" href="assets/img/icon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/img/icon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/img/icon.png">

    <!-- CDN Bootstrap + Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.0/jquery-confirm.min.css">

    <!-- Intern Theme R3 -->
    <link rel="stylesheet" href="./assets/css/uikit.min.css">
    <link rel="stylesheet" href="./assets/css/theme_rota3.css">
    <link rel="stylesheet" href="./assets/plugin/chart/morris.css">
    <link rel="stylesheet" href="../../assets/vendor/flaticon/flaticon.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="loaderSystem(false);">

    <div id="loaderSistema" style="display: block;">
        <div id="loaderSistemaInterna">
            <img src="assets/img/ball-triangle.svg" />
        </div>
    </div>