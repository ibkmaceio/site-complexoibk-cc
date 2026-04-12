<?php

session_start();

// VERIFICACAO DO DOMINIO
include ("./config/config.php");
include ("./config/classeSGBD.php");
include ("./config/classeDb.php");

//  CONEXAO
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

$user_name = htmlspecialchars($_POST['user_name'],ENT_QUOTES);
$pass = sha1($_POST['password']);

$sql = "SELECT * FROM _usuarios_cms WHERE email ='".$user_name."' and senha = '".$pass."' and ativo = 'S' LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

// if username exists
if(mysql_num_rows($result)>0){
  //compare the password

  echo "yes";
    //now set the session from here if needed
    $_SESSION['nome']   = $row['nome'];
    $_SESSION['id']   = $row['id'];
    $_SESSION['nivel']  = $row['permissao'];
    $_SESSION['email']  = $row['email'];

    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR');
    $data = date("d/m/Y H:i");
    $acao = str_replace("'","\'", $sql);

    $insert = "INSERT INTO _logs_acesso (nome,login,data,ip,acao) VALUES ('".$_SESSION['nome']."','".$_SESSION['email']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao."')";
    $query = mysql_query($insert);

}else{
  echo "Login Invalido";
}

?>