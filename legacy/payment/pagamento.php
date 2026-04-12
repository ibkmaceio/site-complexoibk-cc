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

require_once 'PagSeguroLibrary/PagSeguroLibrary.php';

if(!$_POST['credito'] == 1):
    if (empty($_POST["nome"])) {
        echo "<script>alert('Preenhca os dados da compra adequadamente!'); window.history.go(-1); </script>";
    }
endif

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" CONTENT="text/html; charset=UTF-8"/>
    </head>
<body>

<?php

// echo "<script>alert('Fim do Processo!');</script>";
// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";
// break;

if (isset($_POST['pagamento']) == 'S') {

    function retirarCaracteres($txt){
        $txt = str_replace(".", "", $txt);
        $txt = str_replace(",", "", $txt);
        $txt = str_replace("/", "", $txt);
        $txt = str_replace("-", "", $txt);
        $txt = str_replace("(", "", $txt);
        $txt = str_replace(")", "", $txt);
        $txt = str_replace(" ", "", $txt);
        return $txt;
    }

    function gerar_senha($tamanho, $maiuscula, $minuscula, $numeros, $codigos){
        $maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $minus = "abcdefghijklmnopqrstuwxyz";
        $numer = "0123456789";
        $codig = '!@#$%&*()-+.,;?{[}]^><:|';

        $base = '';
        $base .= ($maiuscula) ? $maius : '';
        $base .= ($minuscula) ? $minus : '';
        $base .= ($numeros) ? $numer : '';
        $base .= ($codigos) ? $codig : '';

        srand((float)microtime() * 10000000);
        $senha = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= substr($base, rand(0, strlen($base) - 1), 1);
        }
        return $senha;
    }

    class createPaymentRequest{
        var $Referencia;

        public static function main(){

            $codificacao_referencia = gerar_senha(5, true, true, true, false);
            $GLOBALS['Referencia']  = "REF" . date("dmYHis") . $codificacao_referencia . "";

            global $Referencia;

            $nome                   = $_POST["nome"];
            $sexo                   = $_POST["sexo"];
            $data_formatada         = explode("/", $_POST["dt_nascimento"]);
            $dt_nascimento          = $data_formatada[2]."-".$data_formatada[1]."-".$data_formatada[0];
            $cpf                    = retirarCaracteres($_POST["cpf"]);
            $rg                     = retirarCaracteres($_POST["rg"]);
            $ddd                    = "82";
            $telefone               = retirarCaracteres(substr($_POST["tel_cel"],3));
            $email                  = $_POST["email"];
            $cep                    = retirarCaracteres($_POST["cep"]);
            $endereco               = $_POST["endereco"];
            $numero                 = $_POST["numero"];
            $complemento            = $_POST["complemento"];
            $bairro                 = $_POST["bairro"];
            $cidade                 = $_POST["cidade"];
            $estado                 = $_POST["estado"];

            $sql_id_transacao = mysql_query("SELECT MAX(id)+1 as maxID FROM _doacoes");
            $dados_id_transacao = mysql_fetch_array($sql_id_transacao);

            global $Referencia;

            $directPaymentRequest = new PagSeguroDirectPaymentRequest();
            $directPaymentRequest->setPaymentMode('DEFAULT');
            $directPaymentRequest->setNotificationURL('http://ibkmaceio.com.br/payment/notificacao.php');
            $directPaymentRequest->setCurrency("BRL");

            $directPaymentRequest->addItem($_POST['bilhete'], $_POST['descricao'], $_POST['quantidade'], number_format($_POST['valor_doacao'], 2, '.', ''));
            $directPaymentRequest->setReference($Referencia);

            // Sets shipping information for this payment request
            $CODIGO_SEDEX = PagSeguroShippingType::getCodeByType('SEDEX');
            $directPaymentRequest->setShippingType($CODIGO_SEDEX);
            $directPaymentRequest->setShippingAddress($cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, 'BRA');

            // Sets your customer information.
            $directPaymentRequest->setSender($nome, $email, $ddd, $telefone,'CPF',$cpf);



            try {
                $credentials = new PagSeguroAccountCredentials("diretoria001@adcolconsultoria.com.br","C6209A5A5AC846A990582FA5640E0179");

                $directPaymentRequest->setSenderHash($_POST['user_token']);
                $redirecionar = true;

                if ($_POST['boleto'] == 1){
                    $directPaymentRequest->setPaymentMethod('BOLETO');
                }


                elseif ($_POST['credito'] == 1){

                    $redirecionar = false;
                    $valor = ($_POST['parcelas'] == 1)?$dados_ingresso_preco+$tx_conveniencia_cred:$dados_ingresso_preco;

                    $directPaymentRequest->setPaymentMethod('CREDIT_CARD');
                    $installments = new PagSeguroInstallment(
                        array(
                            'quantity'  => $_POST['parcelas'],
                            'value'     => number_format($_POST['valor_parcela'], 2, '.', '')
                        )
                    );
                    $billingAddress = new PagSeguroBilling(
                        array(
                            'postalCode'    => $cep,
                            'street'        => $endereco,
                            'number'        => $numero,
                            'complement'    => $complemento,
                            'district'      => $bairro,
                            'city'          => $cidade,
                            'state'         => $estado,
                            'country'       => 'BRA'
                        )
                    );

                    $creditCardData = new PagSeguroCreditCardCheckout(
                        array(
                            'token'         => $_POST['cred_token'],
                            'installment'   => $installments,
                            'billing'       => $billingAddress,
                            'holder'        => new PagSeguroCreditCardHolder(
                                array(
                                    'name'          => $nome,
                                    'birthDate'     => date('d/m/Y', strtotime($data_nascimento)) ,
                                    'areaCode'      => $ddd,
                                    'number'        => $telefone,
                                    'documents'     => array(
                                        'type'      => 'CPF',
                                        'value'     => $cpf
                                    )
                                )
                            )
                        )
                    );
                    $directPaymentRequest->setCreditCard($creditCardData);
                }



                elseif ($_POST['debito'] == 1){

                    $directPaymentRequest->setPaymentMethod('EFT');
                    $directPaymentRequest->setOnlineDebit(
                        array(
                            "bankName" => $_POST['banco']
                        )
                    );
                }


                $credentials = PagSeguroConfig::getAccountCredentials();
                $url = $directPaymentRequest->register($credentials);

                self::printPaymentUrl($url, $redirecionar);

                $nome                   = $_POST["nome"];
                $sexo                   = $_POST["sexo"];
                $data_formatada         = explode("/", $_POST["dt_nascimento"]);
                $dt_nascimento          = $data_formatada[2]."-".$data_formatada[1]."-".$data_formatada[0];
                $cpf                    = retirarCaracteres($_POST["cpf"]);
                $rg                     = retirarCaracteres($_POST["rg"]);
                $ddd                    = "82";
                $tel_cel                = retirarCaracteres(substr($_POST["tel_cel"],3));
                $telefone               = retirarCaracteres(substr($_POST["tel_cel"],3));
                $email                  = $_POST["email"];
                $cep                    = retirarCaracteres($_POST["cep"]);
                $endereco               = $_POST["endereco"];
                $numero                 = $_POST["numero"];
                $complemento            = $_POST["complemento"];
                $bairro                 = $_POST["bairro"];
                $cidade                 = $_POST["cidade"];
                $estado                 = $_POST["estado"];
                $CartaoNome             = $_POST['cartaoNome'];
                $CartaoCPF              = $_POST['cartaoCPF'];
                $CartaoEmail            = $_POST['cartaoEMAIL'];
                $cartaoRG               = $_POST['cartaoRG'];
                $valorTotal             = $_POST['valor_doacao'];

                $sql_id_transacao = ("SELECT MAX(id)+1 as maxID FROM _doacoes");
                $dados_id_transacao = mysql_fetch_array($sql_id_transacao);
                global $Referencia;

                $inserir_transacao = mysql_query("INSERT INTO _doacoes (
                    nome,
                    email,
                    endereco,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado,
                    cep,
                    tel_cel,
                    telefone,
                    cpf,
                    rg,
                    dt_nascimento,
                    sexo,
                    totalValor,
                    modalidade,
                    forma_entrega,
                    Referencia,
                    StatusTransacao) VALUES (
                    '" . $nome . "',
                    '" . $email . "',
                    '" . $endereco . "',
                    '" . $numero . "',
                    '" . $complemento . "',
                    '" . $bairro . "',
                    '" . utf8_decode($cidade) . "',
                    '" . $estado . "',
                    '" . $cep . "',
                    '" . "(".$ddd .") " . $tel_cel . "',
                    '" . "(".$ddd .") " . $telefone . "',
                    '" . $_POST['cpf'] . "',
                    '" . $rg . "',
                    '" . $_POST['dt_nascimento'] . "',
                    '" . $sexo . "',
                    '" . $valorTotal . "',
                    '" . $_POST['modalidade'] . "',
                    '" . $_POST['forma_entrega'] . "',
                    '" . $Referencia . "',
                    'Aguardando PagSeguro')
                ");

            } catch (PagSeguroServiceException $e) {
                echo json_encode(array('success'=>false,'message'=>$e->getMessage()) );
            }
        }

        public static function printPaymentUrl($url, $boleto = false){
            if ($url) {
                if($boleto){
                    echo "<script type='text/javascript'>window.location.href='" . $url->getPaymentLink(). "';</script>";
                }else{
                    json_encode(array('success'=>true));
                    echo "<script type='text/javascript'>window.location.href='/finish.php';</script>";
                }
            }
        }
    }
    createPaymentRequest::main();

    // echo "<script>alert('Fim do Processo!');</script>";
    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";
    // break;
}
?>
</body>
</html>