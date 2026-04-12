<?php

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', '79F4ECC023CE4FCA87F7AD553916063B');
//define('TOKEN', '8C195252F5CF427D9AD452FD134D0E32');


include("../cms/config/classeSGBD.php");
include("../cms/config/classeDb.php");
include("../cms/config/config.php");
include("../cms/config/class.php");

/*
if($select_db){
echo "ta no BD";
}else{
echo "nao";
}
*/

class PagSeguroNpi
{

  private $timeout = 20; // Timeout em segundos

  public function notificationPost()
  {
    $postdata = 'Comando=validar&Token=' . TOKEN;
    foreach ($_POST as $key => $value) {
      $valued = $this->clearStr($value);
      $postdata .= "&$key=$valued";
    }
    return $this->verify($postdata);
  }

  private function clearStr($str)
  {
    if (!get_magic_quotes_gpc()) {
      $str = addslashes($str);
    }
    return $str;
  }

  private function verify($data)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = trim(curl_exec($curl));
    curl_close($curl);
    return $result;
  }

}

if (count($_POST) > 0) {


  if ($_POST['notificationType'] = "transaction" && $_POST['notificationType'] != null) {

    $email = "sacingressosrecife@gmail.com";
    $token = "79F4ECC023CE4FCA87F7AD553916063B";
    //$email = "oiromildojunior@yahoo.com.br";
    //$token = "8C195252F5CF427D9AD452FD134D0E32";
    $notificationCode = $_POST['notificationCode'];
    $url = "https://ws.pagseguro.uol.com.br/v2/transactions/" . $notificationCode . "?email=" . $email . "&token=" . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $dados = curl_exec($curl);

//Você precisa criar um arquivo “Txt” chamado de “log” e informar o caminho deste arquivo.
    $log = fopen("log.txt", "a+");
    fwrite($log, $dados);
    fclose($log);

    if ($dados == 'Unauthorized') {
      print_r($dados);
      exit;
    }

    curl_close($curl);

    $dados = simplexml_load_string($dados);

    if (count($dados->error) > 0) {
      print_r($dados);
      exit;
    }

    switch ($dados->status) {
      case 1:
        var_dump($dados);
        break;
      case 2:
        var_dump($dados);
        break;
      case 3:
        var_dump($dados);
        break;
      case 4:
        var_dump($dados);
        break;
      case 5:
        var_dump($dados);
        break;
      case 6:
        var_dump($dados);
        break;
      case 7:
        var_dump($dados);
        break;
      default:
        echo "Erro com o tratamento do XML";
        break;
    }
  }

// POST recebido, indica que é a requisição do NPI.
  $npi = new PagSeguroNpi();
  $result = $npi->notificationPost();

//https://pagseguro.uol.com.br/desenvolvedor/retorno_automatico_de_dados.jhtml#rmcl
  $transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
  $VendedorEmail = isset($_POST['VendedorEmail']) ? $_POST['VendedorEmail'] : '';
  $Referencia = isset($_POST['Referencia']) ? $_POST['Referencia'] : '';
  $Extras = isset($_POST['Extras']) ? $_POST['Extras'] : '';
  $TipoFrete = isset($_POST['TipoFrete']) ? $_POST['TipoFrete'] : '';
  $ValorFrete = isset($_POST['ValorFrete']) ? $_POST['ValorFrete'] : '';
  $Anotacao = isset($_POST['Anotacao']) ? $_POST['Anotacao'] : '';
  $DataTransacao = isset($_POST['DataTransacao']) ? $_POST['DataTransacao'] : '';
  $TipoPagamento = isset($_POST['TipoPagamento']) ? $_POST['TipoPagamento'] : '';
  $StatusTransacao = isset($_POST['StatusTransacao']) ? $_POST['StatusTransacao'] : '';
  $CliNome = isset($_POST['CliNome']) ? $_POST['CliNome'] : '';
  $CliEmail = isset($_POST['CliEmail']) ? $_POST['CliEmail'] : '';
  $CliEndereco = isset($_POST['CliEndereco']) ? $_POST['CliEndereco'] : '';
  $CliNumero = isset($_POST['CliNumero']) ? $_POST['CliNumero'] : '';
  $CliComplemento = isset($_POST['CliComplemento']) ? $_POST['CliComplemento'] : '';
  $CliBairro = isset($_POST['CliBairro']) ? $_POST['CliBairro'] : '';
  $CliCidade = isset($_POST['CliCidade']) ? $_POST['CliCidade'] : '';
  $CliEstado = isset($_POST['CliEstado']) ? $_POST['CliEstado'] : '';
  $CliCEP = isset($_POST['CliCEP']) ? $_POST['CliCEP'] : '';
  $CliTelefone = isset($_POST['CliTelefone']) ? $_POST['CliTelefone'] : '';
  $ProdID_x = isset($_POST['ProdID_x']) ? $_POST['ProdID_x'] : '';
  $ProdDescricao_x = isset($_POST['ProdDescricao_x']) ? $_POST['ProdDescricao_x'] : '';
  $ProdValor_x = isset($_POST['ProdValor_x']) ? $_POST['ProdValor_x'] : '';
  $ProdQuantidade_x = isset($_POST['ProdQuantidade_x']) ? $_POST['ProdQuantidade_x'] : '';
  $ProdFrete_x = isset($_POST['ProdFrete_x']) ? $_POST['ProdFrete_x'] : '';
  $NumItens = isset($_POST['NumItens']) ? $_POST['NumItens'] : '';
  $Parcelas = isset($_POST['Parcelas']) ? $_POST['Parcelas'] : '';

  if ($result == "VERIFICADO") {

// Envio do email com Voucher para o cliente
    if ($StatusTransacao == 'Aprovado') {

//ENCONTRAR A ULTIMA COMPRA
      $sql_transacoes_ref = mysql_query("SELECT * FROM transacoes WHERE Referencia = '" . $Referencia . "' ");
      $dados_transacoes_ref = mysql_fetch_array($sql_transacoes_ref);

#MENSAGEM PARA O CLIENTE
// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
      require("phpMailer/class.phpmailer.php");

// Inicia a classe PHPMailer
      $mail = new PHPMailer();

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $mail->IsSMTP(); // Define que a mensagem será SMTP
//$mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
      $mail->SMTPAuth = false; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
//$mail->Username = ''; // Usuário do servidor SMTP (endereço de email)
//$mail->Password = ''; // Senha do servidor SMTP (senha do email usado)

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $mail->From = 'contato@ingressosrecife.com'; // Seu e-mail
      $mail->Sender = 'contato@ingressosrecife.com'; // Seu e-mail
      $mail->FromName = 'Ingressos Recife'; // Seu nome

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $mail->AddAddress($dados_transacoes_ref['CliEmail'], $dados_transacoes_ref['CliNome']);
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
      $mail->AddBCC('contato@bluevox.com.br', 'BlueVox'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
      $mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $mail->Subject = "[VOUCHER] Ingressos Recife."; // Assunto da mensagem
      $mail->Body = "
<html>
<head>
  <title>[VOUCHER] Ingressos Recife.</title>
</head>
<body>
  <h1>Olá</h1>
  <p>Você realizou uma compra no site Ingressos Recife.</p>
  <p><a href='http://www.ingressosrecife.com/voucher_print_e.php?ref=" . $dados_transacoes_ref['Referencia'] . "'>Clique aqui</a> para imprimir seu voucher.</p>
  <br />
  <p>Atenciosamente,<br />
    Ingressos Recife<br />
    E-mail: contato@ingressosrecife.com<br />
    Telefone: (81) 9653-2541 | (81) 8645-1407<br /></p>
  </body>
  </html>";
//$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n ';

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo

// Envia o e-mail
      $enviado = $mail->Send();

// Limpa os destinatários e os anexos
      $mail->ClearAllRecipients();
      $mail->ClearAttachments();
    }


//O post foi validado pelo PagSeguro.


// for ($i=0; $i < sizeof($ProdValor_x); $i++) {
//   $valor_total += $ProdValor_x[$i];
// }


//ATUALiZAR TABELA DE TRANSACAO COM NOVO STATUS
    mysql_query("UPDATE transacoes SET TransacaoID      = '" . $transacaoID . "',
  VendedorEmail     = '" . $VendedorEmail . "',
  Extras            = '" . $Extras . "',
  TipoFrete         = '" . $TipoFrete . "',
  ValorFrete        = '" . $ValorFrete . "',
  Anotacao          = '" . $Anotacao . "',
  DataTransacao     = '" . $DataTransacao . "',
  TipoPagamento     = '" . $TipoPagamento . "',
  StatusTransacao   = '" . $StatusTransacao . "',
  NumItens          = '" . $NumItens . "',
  Parcelas          = '" . $Parcelas . "'
  WHERE Referencia  = '" . $Referencia . "' ");


//Verificar comissário
    $sql_verif_comissario = mysql_query("SELECT * FROM comissario_vendas WHERE referencia = '" . $Referencia . "' ");
    if (mysql_num_rows($sql_verif_comissario) > 0) {

      while ($dados_verif_comissario = mysql_fetch_array($sql_verif_comissario)) {
        if (($StatusTransacao == 'Aprovado') OR ($StatusTransacao == 'Completo')) {
          mysql_query("UPDATE comissario_vendas SET concluido = 'S' WHERE referencia  = '" . $Referencia . "' ");
        } else {
          mysql_query("UPDATE comissario_vendas SET concluido = 'N' WHERE referencia  = '" . $Referencia . "' ");
        }
      }

    }

    /* mysql_query("INSERT INTO logs_pagseguro( TransacaoID,
    VendedorEmail,
    Extras,
    TipoFrete,
    ValorFrete,
    Anotacao,
    DataTransacao,
    TipoPagamento,
    StatusTransacao,
    NumItens,
    Parcelas,
    Referencia) VALUES( '".$transacaoID."',
    '".$VendedorEmail."',
    '".$Extras."',
    '".$TipoFrete."',
    '".$ValorFrete."',
    '".$Anotacao."',
    '".$DataTransacao."',
    '".$TipoPagamento."',
    '".$StatusTransacao."',
    '".$NumItens."',
    '".$Parcelas."',
    '".$Referencia."' ");*/

//ATUALiZAR TABELA DE TRANSACAO COM NOVO STATUS
// mysql_query("UPDATE clientes SET  CliNome = '".$CliNome."',
//                                   CliEmail = '".$CliEmail."',
//                                   CliEndereco = '".$CliEndereco."',
//                                   CliNumero = '".$CliNumero."',
//                                   CliComplemento = '".$CliComplemento."',
//                                   CliBairro = '".$CliBairro."',
//                                   CliCidade = '".$CliCidade."',
//                                   CliEstado = '".$CliEstado."',
//                                   CliCEP = '".$CliCEP."',
//                                   CliTelefoneCompleto = '".$CliTelefone."'
//                                   WHERE CliCPF = '".$CliCPF."' ");

  } else if ($result == "FALSO") {
//O post não foi validado pelo PagSeguro.
  } else {
//Erro na integração com o PagSeguro.
  }

} else {
// POST não recebido, indica que a requisição é o retorno do Checkout PagSeguro.
// No término do checkout o usuário é redirecionado para este bloco.
  ?>
  <h3>Obrigado por efetuar a compra.</h3>
<?php

//echo "<script type='text/javascript'>window.location.href='http://rota3.com.br/ingressosrecife/';</script>";

}

?>
