<?php
header('Content-Type: text/html; charset=UTF-8');
/*
************************************************************************
Copyright [2011] [PagSeguro Internet Ltda.]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/

require_once dirname(__DIR__) . "PagSeguroLibrary/PagSeguroLibrary.php";

include("../cms/config/classeSGBD.php");
include("../cms/config/classeDb.php");
include("../cms/config/config.php");
include("../cms/config/class.php");

class searchTransactionsByDateInterval
{

  public static function main()
  {

    $initialDate = self::subDiaData(date('d/m/Y'), 8);
    $finalDate = date("Y-m-d\TH:i");

    $pageNumber = 1;
    $maxPageResults = 3000;

    try {

      /*
      * #### Crendencials #####
      * Substitute the parameters below with your credentials (e-mail and token)
      * You can also get your credentails from a config file. See an example:
      * $credentials = PagSeguroConfig::getAccountCredentials();
      */
      $credentials = PagSeguroConfig::getAccountCredentials();

      $result = PagSeguroTransactionSearchService::searchByDate($credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate);

      self::printResult($result, $initialDate, $finalDate);

    } catch (PagSeguroServiceException $e) {
      die($e->getMessage());
    }

  }

  public static function subDiaData($data, $dias)
  {
    $data = explode("/", $data);
    return date('Y-m-d\TH:i', mktime(0, 0, 0, $data[1], $data[0] - $dias, $data[2]));
  }

  public static function printResult(PagSeguroTransactionSearchResult $result, $initialDate, $finalDate)
  {

//$finalDate = $finalDate ? $finalDate : 'now';
//echo "<h2>Search transactions by date</h2>";
//echo "<h3>$initialDate to $finalDate</h3>";
    $transactions = $result->getTransactions();
    if (is_array($transactions) && count($transactions) > 0) {
      $result = date('d/m/Y') . "<br>";
      foreach ($transactions as $key => $transactionSummary) {

        $status = $transactionSummary->getStatus()->getValue();

        switch ($status) {
          case 1:
            $msg_status = 'Aguardando Pagto';
            break;
          case 2:
            $msg_status = 'Em Análise';
            break;
          case 3:
            $msg_status = 'Aprovado';
            break;
          case 4:
            $msg_status = 'Completo';
            break;
          case 5:
            $msg_status = 'Em Disputa';
            break;
          case 6:
            $msg_status = 'Devolvido';
            break;
          case 7:
            $msg_status = 'Cancelado';
            break;
          default:
            $msg_status = 'Aguardando Pagseguro';
            break;
        }

        $tipo = $transactionSummary->getPaymentMethod()->getType()->getValue();
        switch ($tipo) {
          case 1:
            $msg_tipo = 'Cartão de Crédito';
            break;
          case 2:
            $msg_tipo = 'Boleto';
            break;
          case 3:
            $msg_tipo = 'Pagamento Online';
            break;
          case 4:
            $msg_tipo = 'Saldo PagSeguro';
            break;
          case 5:
            $msg_tipo = 'Oi Paggo';
            break;
          default:
            $msg_tipo = '';
            break;
        }

// $tipo =  $transactionSummary->getType()->getValue();

        $data = $transactionSummary->getDate();

        $nova = substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . " " . substr($data, 11, 8);

        $transacao = str_replace("-", "", $transactionSummary->getCode());

//ATUALiZAR TABELA DE TRANSACAO COM NOVO STATUS

//Verificar comissário
        $sql_has = mysql_query("SELECT * FROM transacoes WHERE Referencia  = '{$transactionSummary->getReference()}' ");
        if (mysql_num_rows($sql_has) > 0) {

          $sql = "UPDATE transacoes SET TransacaoID = '{$transacao}',
                VendedorEmail     = 'sacingressosrecife@gmail.com',
                DataTransacao     = '{$nova}',
                StatusTransacao   = '{$msg_status}',
                TipoPagamento     = '{$msg_tipo}'
                WHERE Referencia  = '{$transactionSummary->getReference()}' ";
          $res = mysql_query($sql);


          $result .= "atualizado ref: {$transactionSummary->getReference()} - {$msg_status} - {$msg_tipo} - {$data}";
          $result .= "<br>";

          if ($status == 1) {
//self::sendVoucher($transactionSummary->getReference());
          }
        }

      }
    }
    echo $result;
  }

  public function sendVoucher($referencia)
  {

//ENCONTRAR A ULTIMA COMPRA
    $sql_transacoes_ref = mysql_query("SELECT * FROM transacoes WHERE Referencia = '" . $referencia . "' ");
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

    return $enviado;
  }

}

searchTransactionsByDateInterval::main();

?>