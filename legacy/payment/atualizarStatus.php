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

class SearchTransactionByCode
{

  public static function main()
  {

    //$transaction_code = '93310F57FB11411EA0C46DDE2B6B9F8B';

    $credentials = new PagSeguroAccountCredentials("sacingressosrecife@gmail.com", "79F4ECC023CE4FCA87F7AD553916063B");
    //$credentials = new PagSeguroAccountCredentials("oiromildojunior@yahoo.com.br", "8C195252F5CF427D9AD452FD134D0E32");

    $sql_comparacao = mysql_query("SELECT * FROM transacoes WHERE TransacaoID IN ('93310F57FB11411EA0C46DDE2B6B9F8B')");
    while ($dados_comparacao = mysql_fetch_array($sql_comparacao)) {

      $transaction_code = $dados_comparacao['TransacaoID'];

      try {

        /*
        * #### Crendencials #####
        * Substitute the parameters below with your credentials (e-mail and token)
        * You can also get your credentails from a config file. See an example:
        * $credentials = PagSeguroConfig::getAccountCredentials();
        */
        $credentials = PagSeguroConfig::getAccountCredentials();
        $transaction = PagSeguroTransactionSearchService::searchByCode($credentials, $transaction_code);

        self::printTransaction($transaction, $transaction_code);

      } catch (PagSeguroServiceException $e) {
        die($e->getMessage());
      }

    }

  }


  public function printTransaction(PagSeguroTransaction $transaction, $transaction_code)
  {
    /*echo "<pre>";
    //print_r($transaction);
    echo "</pre>";

    echo "TESTE: ".$transaction_code;

    echo "<h2>Transaction search by code result";
    echo "<h3>Code: " . 		$transaction->getCode()	.'</h3>';
    echo "<h3>Status: " . 		$transaction->getStatus()->getTypeFromValue()	.'</h3>';
    echo "<h3>COD STATUS: " . 		$transaction->getStatus()->getValue()	.'</h3>'; */

    $cod_status = $transaction->getStatus()->getValue();


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


    //echo "STATUS: ".$msg_status."<br>";

    if (!empty($transaction_code)) {
      $sql = mysql_query("UPDATE transacoes SET StatusTransacao = '" . $msg_status . "' WHERE TransacaoID = '" . $transaction_code . "' ");
      if ($sql) {
        echo "<b>ATUALIZOU Transacao: </b>" . $transaction_code . " <b>PARA<b> " . $msg_status;
      } else {
        echo "<b>ERRO AO ATUALIZAR Transacao:</b> " . $transaction_code . " <b>PARA</b> " . $msg_status;
      }
    }

    /*echo "<h4>Reference: " . 	$transaction->getReference() . "</h4>";

    if ($transaction->getSender()) {
      echo "<h4>Sender data:</h4>";
      echo  "Name: ".		$transaction->getSender()->getName() 	.'<br>';
      echo  "Email: ". 	$transaction->getSender()->getEmail()	.'<br>';
      if ( $transaction->getSender()->getPhone() ) {
        echo  "Phone: ". $transaction->getSender()->getPhone()->getAreaCode() . " - " . $transaction->getSender()->getPhone()->getNumber();
      }
    }

    if ($transaction->getItems()) {
      echo "<h4>Items:</h4>";
      if (is_array($transaction->getItems())) {
        foreach($transaction->getItems() as $key => $item) {
          echo "Id: ". 				$item->getId()				.'<br>'; // prints the item id, p.e. I39
          echo "Description: ". 		$item->getDescription()		.'<br>'; // prints the item description, p.e. Notebook prata
          echo "Quantidade: ". 		$item->getQuantity()		.'<br>'; // prints the item quantity, p.e. 1
          echo "Amount: ". 			$item->getAmount()			.'<br>'; // prints the item unit value, p.e. 3050.68
          echo "<hr>";
        }
      }
    }

    if ($transaction->getShipping()) {
      echo "<h4>Shipping information:</h4>";
      if ($transaction->getShipping()->getAddress()) {
        echo "Postal code: ".	$transaction->getShipping()->getAddress()->getPostalCode().'<br>';
        echo "Street: ".  		$transaction->getShipping()->getAddress()->getStreet().'<br>';
        echo "Number: ". 	 	$transaction->getShipping()->getAddress()->getNumber().'<br>';
        echo "Complement: ". 	$transaction->getShipping()->getAddress()->getComplement().'<br>';
        echo "District: ". 	 	$transaction->getShipping()->getAddress()->getDistrict().'<br>';
        echo "City: ".	 	 	$transaction->getShipping()->getAddress()->getCity().'<br>';
        echo "State: ". 		$transaction->getShipping()->getAddress()->getState().'<br>';
        echo "Country: ". 		$transaction->getShipping()->getAddress()->getCountry().'<br>';
      }
      echo "Shipping type: ".		$transaction->getShipping()->getType()->getTypeFromValue().'<br>';
      echo "Shipping cost: ".	$transaction->getShipping()->getCost().'<br>';
    }*/


  }

}

SearchTransactionByCode::main();

?>