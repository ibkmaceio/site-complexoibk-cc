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


/*
PEGA VARIAVEIS : POST
*/

$slug       = $_POST['slug'];
$ip         = $_POST['ip'];
$like_s     = "1";

/*
VERIFICA IP EXISTENTE
*/

$verifica = mysql_query("SELECT * FROM _noticias_like WHERE  ip =  '$ip'")
or die(mysql_error());
$verifica = mysql_num_rows($verifica);

if($verifica > 0){

  /*

  PEGA O UTIMO REGISTRO E COLOCA 0 NO LIKE_S

  */

  $query = mysql_query("SELECT slug FROM _noticias_like WHERE slug = '".$_POST['slug']. "'");
  $res = mysql_fetch_array($query);
  $slug = $res['slug'];
  $query = mysql_query("UPDATE _noticias_like SET ip = '', like_s = '0' WHERE slug = '".$slug."'");

  /*
  VERIFICA O TOTAL DE LIKES
  */

  $soma_likes = mysql_query("SELECT  *,sum(like_s) as total_likes FROM _noticias_like WHERE slug = '".$_POST['slug']."' ");
  $dados_soma_geral = mysql_fetch_array($soma_likes);
  $total += $dados_soma_geral['total_likes'];
  // echo "<script type='text/javascript'>alert('Deslike!!');</script>";
  echo "<span class='animate bounceIn'>" .$total. "</span>";

}

else {
  /*

  NOVO REGISTRO

  */
  $query_like = mysql_query ("INSERT INTO _noticias_like (slug,like_s,ip) VALUES ('".$slug."','".$like_s."','".$_SERVER['REMOTE_ADDR']."') ");

  if ($query_like) {
    $soma_likes_2 = mysql_query("SELECT  *,sum(like_s) as total_likes_2 FROM _noticias_like WHERE slug = '".$_POST['slug']."' ");
    $dados_soma_geral_2 = mysql_fetch_array($soma_likes_2);
    $total += $dados_soma_geral_2['total_likes_2'];
    // echo "<script type='text/javascript'>alert('Like!');</script>";
    echo "<span class='animate bounceIn'>" .$total. "</span>";
  }
}
?>