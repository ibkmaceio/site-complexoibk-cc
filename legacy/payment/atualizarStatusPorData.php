<?php
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

require_once "PagSeguroLibrary/PagSeguroLibrary.php";
include("../cms/config/classeSGBD.php");
include("../cms/config/classeDb.php");
include("../cms/config/config.php");
include("../cms/config/class.php");

class searchTransactionsByDateInterval
{

  public static function main()
  {

    $initialDate = '2013-06-30T00:00';
    $finalDate = '2013-07-30T00:00';

    $pageNumber = 1;
    $maxPageResults = 3000;

    try {

      /*
      * #### Crendencials #####
      * Substitute the parameters below with your credentials (e-mail and token)
      * You can also get your credentails from a config file. See an example:
      * $credentials = PagSeguroConfig::getAccountCredentials();
      */
      //$credentials = new PagSeguroAccountCredentials("oiromildojunior@yahoo.com.br", "8C195252F5CF427D9AD452FD134D0E32");
      $credentials = new PagSeguroAccountCredentials("sacingressosrecife@gmail.com", "79F4ECC023CE4FCA87F7AD553916063B");

      $result = PagSeguroTransactionSearchService::searchByDate($credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate);

      self::printResult($result, $initialDate, $finalDate);

    } catch (PagSeguroServiceException $e) {
      die($e->getMessage());
    }

  }


  public static function printResult(PagSeguroTransactionSearchResult $result, $initialDate, $finalDate)
  {
    $finalDate = $finalDate ? $finalDate : 'now';
    //echo "<h2>Search transactions by date</h2>";
    //echo "<h3>$initialDate to $finalDate</h3>";
    $transactions = $result->getTransactions();
    if (is_array($transactions) && count($transactions) > 0) {
      foreach ($transactions as $key => $transactionSummary) {

        $cod_status = $transactionSummary->getStatus()->getValue();

        switch ($cod_status) {
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
            $msg_status = '';
            break;
        }

        $transaction_code = str_replace("-", "", $transactionSummary->getCode());


        $sql_verif = mysql_query("SELECT * FROM transacoes WHERE TransacaoID = '" . $transaction_code . "' ");
        if (mysql_num_rows($sql_verif) > 0) {
          $sql = mysql_query("UPDATE transacoes SET StatusTransacao = '" . utf8_decode($msg_status) . "' WHERE TransacaoID = '" . $transaction_code . "' ");
          if ($sql) {
            echo "<br /><strong>ATUALIZOU Transacao: </strong>" . $transaction_code . " <strong>PARA<strong> " . utf8_decode($msg_status) . "<br />";
          } else {
            echo "<br /><strong>ERRO AO ATUALIZAR Transacao:</strong> " . $transaction_code . " <strong>PARA</strong> " . $msg_status . "<br />";
          }
        } else {
          echo "<br /><strong>ERRO!! Transacao:</strong> " . $transaction_code . " <strong>Nao Existe</strong> <br /> <br />";
        }

        /*echo "Code: " . 		$transactionSummary->getCode()							. "<br>";
        echo "Code Status: " . 		$transactionSummary->getStatus()->getValue()							. "<br>";
        echo "Reference: " .	$transactionSummary->getReference()						. "<br>";
        echo "amount: " . 		$transactionSummary->getGrossAmount()					. "<br>";
        echo "<hr>";*/
      }
    }
  }


}

searchTransactionsByDateInterval::main();

?>
