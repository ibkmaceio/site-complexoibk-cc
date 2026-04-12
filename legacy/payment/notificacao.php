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

if ($_SERVER['SERVER_NAME'] == "http://ibkmaceio.com.br") { $baseURL = ""; }
elseif  ($_SERVER['SERVER_NAME'] != "http://ibkmaceio.com.br") { $baseURL = ""; }
else { echo "Nenhum modelo de BASEURL selecionado"; }

include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/config.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeSGBD.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeDb.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/data.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/function.php");

// Chamada do Banco de dados
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

header('Content-Type: text/html; charset=UTF-8');
define('TOKEN', 'C6209A5A5AC846A990582FA5640E0179');

require_once 'PagSeguroLibrary/PagSeguroLibrary.php';

class PagSeguroNpi {

    private $timeout = 20; // Timeout em segundos

    public function notificationPost() {
        $postdata = 'Comando=validar&Token=' . TOKEN;
        foreach ($_POST as $key => $value) {
            $valued = $this->clearStr($value);
            $postdata .= "&$key=$valued";
        }
        return $this->verify($postdata);
    }

    private function clearStr($str) {
        if (!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
        return $str;
    }

    private function verify($data) {
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

        try {
            $notificationCode = $_POST['notificationCode'];
            $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()

            $response = PagSeguroNotificationService::checkTransaction(
            $credentials,
            $notificationCode
            );
        }

        catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }

        switch ($response->getStatus()->getValue()) {
            case 1:
            var_dump($response);
            break;
            case 2:
            var_dump($response);
            break;
            case 3:
            var_dump($response);
            break;
            case 4:
            var_dump($response);
            break;
            case 5:
            var_dump($response);
            break;
            case 6:
            var_dump($response);
            break;
            case 7:
            var_dump($response);
            break;
            default:
            echo "Erro com o tratamento do XML";
            break;
        }
    }

    $statusList = function ($value) {
        $status = array(
            1=>'Aguardando Pagto',
            2=>'Em Análise',
            3=>'Aprovado',
            4=>'Completo',
            5=>'Em Disputa',
            6=>'Devolvido',
            7=>'Cancelado',
            8=>'ChargeBack',
            9=>'Contestação'
        );
        return $status[$value];
    };

    $formList = function ($forma) {
        $formaArray= explode('_', $forma);
        if(end($formaArray) == 'CARD'){
            return 'Cartão de Crédito';
        }else if(end($formaArray) == 'BOLETO'){
            return 'Boleto';
        }else{
            return 'Transferência online';
        }
    };

    $transacaoID = str_replace('-','',$response->getCode()) ;
    $VendedorEmail = 'diretoria001@adcolconsultoria.com.br';

    $Referencia =$response->getReference();
    $Extras =$response->getExtraAmount();
    $TipoFrete =$response->getShipping()->getType()->getTypeFromValue();
    $ValorFrete = $response->getShipping()->getCost();

    $Anotacao               = isset($_POST['Anotacao']) ? $_POST['Anotacao'] : '';
    $DataTransacao          = $response->getDate();
    $TipoPagamento          = $response->getPaymentMethod()->getCode();
    $code                   = (array)$TipoPagamento;
    $tips                   = new PagSeguroPaymentMethodCode();
    $valorTipo              = array_values($code);
    $TipoPagamento          = $formList($tips->getTypeFromValue($valorTipo[0]));
    $StatusTransacao        = $statusList($response->getStatus()->getValue());
    $nome                   = isset($_POST['CliNome']) ? $_POST['CliNome'] : '';
    $email                  = isset($_POST['CliEmail']) ? $_POST['CliEmail'] : '';
    $endereco               = isset($_POST['CliEndereco']) ? $_POST['CliEndereco'] : '';
    $numero                 = isset($_POST['CliNumero']) ? $_POST['CliNumero'] : '';
    $complemento            = isset($_POST['CliComplemento']) ? $_POST['CliComplemento'] : '';
    $bairro                 = isset($_POST['CliBairro']) ? $_POST['CliBairro'] : '';
    $cidade                 = isset($_POST['CliCidade']) ? $_POST['CliCidade'] : '';
    $estado                 = isset($_POST['CliEstado']) ? $_POST['CliEstado'] : '';
    $cep                    = isset($_POST['CliCEP']) ? $_POST['CliCEP'] : '';
    $telefone               = isset($_POST['CliTelefone']) ? $_POST['CliTelefone'] : '';
    $ProdID_x               = isset($_POST['ProdID_x']) ? $_POST['ProdID_x'] : '';
    $ProdDescricao_x        = isset($_POST['ProdDescricao_x']) ? $_POST['ProdDescricao_x'] : '';
    $ProdValor_x            = isset($_POST['ProdValor_x']) ? $_POST['ProdValor_x'] : '';
    $ProdQuantidade_x       = isset($_POST['ProdQuantidade_x']) ? $_POST['ProdQuantidade_x'] : '';
    $ProdFrete_x            = isset($_POST['ProdFrete_x']) ? $_POST['ProdFrete_x'] : '';
    $NumItens               = $response->getItemCount();
    $Parcelas               = $response->getInstallmentCount();

    if ($response) {

        // ENVIA EMAIL COM O VOUCHER PARA O CLIENTE
        if ($response->getStatus()->getTypeFromValue() == 'PAID') {

            //ENCONTRAR A ULTIMA COMPRA
            $sql_transacoes_ref = mysql_query("SELECT * FROM _doacoes WHERE Referencia = '" . $Referencia . "' ");
            $dados_transacoes_ref = mysql_fetch_array($sql_transacoes_ref);

            // Nova Implementação
            // 24 de FEV de 2017
            // Ederson Rodrigues

            //PEGAR NOTIFICACAO E ENVIAR VOUCHER VIA POST PARA SERVIDOR SMTP
            $nome                   = $dados_transacoes_ref['nome'];
            $email                  = $dados_transacoes_ref['email'];
            $referencia             = $dados_transacoes_ref['Referencia'];
            $TransacaoID            = $dados_transacoes_ref['TransacaoID'];
            $assunto                = "Doação Realizada [RECIBO]";
            $email_empresa          = "contato@ibkmaceio.com.br";
            $email_contratante      = "ederson@rota3.com.br";
            $empresa                = "IBK Maceió";
            $dominio                = "www.ibkmaceio.com.br";

            $dados_smtp = array(
            "id"                =>$id,
            "nome"              =>$nome,
            "email"             =>$email,
            "referencia"        =>$referencia,
            "TransacaoID"       =>$TransacaoID,
            "assunto"           =>$assunto,
            "email_empresa"     =>$email_empresa,
            "email_contratante" =>$email_contratante,
            "empresa"           =>$empresa,
            "dominio"           =>$dominio
            );

            $url = "http://smtp.rota3.com.br/post_notificacao.php";

            //CURL
            $curl = curl_init();
            //URL ENVIADA
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            //SEND POST
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dados_smtp);
            curl_exec($curl);
            curl_close($curl);

            // FIM DO ENVIO POST
        }


        //ATUALIZAR TABELA DE TRANSACAO COM NOVO STATUS
        mysql_query("UPDATE _doacoes SET TransacaoID  = '" . $transacaoID . "',
        VendedorEmail     = '" . $VendedorEmail . "',
        DataTransacao     = '" . $DataTransacao . "',
        TipoPagamento     = '" . $TipoPagamento . "',
        StatusTransacao   = '" . $StatusTransacao . "'
        WHERE Referencia  = '" . $Referencia . "' ");
    }

    else if ($result == "FALSO") {
        //O post não foi validado pelo PagSeguro.
    }

    else {
        //Erro na integração com o PagSeguro.
    }
}
else {
    // POST não recebido, indica que a requisição é o retorno do Checkout PagSeguro.
    // No término do checkout o usuário é redirecionado para este bloco.
    echo "<h3>Obrigado por efetuar a compra.</h3>";
    echo "<script type='text/javascript'>window.location.href='/';</script>";
}
?>