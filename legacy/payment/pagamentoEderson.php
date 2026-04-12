<?php

include("../cms/config/config.php");
include("../cms/config/classeSGBD.php");
include("../cms/config/classeDb.php");
require_once 'PagSeguroLibrary/PagSeguroLibrary.php';

function ValidaData($dat)
{
    $data = explode("/", "$dat");
    $d = $data[0];
    $m = $data[1];
    $y = $data[2];
    $res = checkdate($m, $d, $y);
    if ($res == 1) {
        return true;
    } else {
        return false;
    }
}

?>

<?php if(!$_POST['credito']):?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" CONTENT="text/html; charset=UTF-8"/>
        <style>

        #loaderSistema {
            z-index: 9999999 !important;
            background: #c00;
            height: 100%;
            left: 0;
            opacity: 0.9;
            position: fixed;
            top: 0;
            width: 100%;
        }

        #loaderSistemaInterna {
            top: 45%;
            text-align: center;
            font-family: Tahoma, Geneva, sans-serif;
            position: relative;
        }


    </style>

    <!--<script>
        function loaderSystem(acao) {
            if (acao) {
                $('#loaderSistema').show();
            } else {
                $('#loaderSistema').hide();
            }
        }
    </script> -->


    <?php
        if (empty($_POST["pagador_nome"])) {
            echo "<script>alert('Erro ao finalizar a compra, tente novamente.');//window.history.go(-1); </script>";
        }
    ?>

</head>

<body>
    <!--<div id="loaderSistema" style="display: block;">
        <div id="loaderSistemaInterna"><img src="32.gif" style="padding:10px; background:#fff; margin-bottom:5px;"/><br/>
            <span style="color:  #fff; font-size: 11px;">Redirecionando para o <strong>PagSeguro</strong> ...</span>
        </div>
    </div> -->
    <?php endif?>
    <?php

    if (isset($_POST['pagamento']) == 'S') {
        class createPaymentRequest{
            var $Referencia;

            public static function main(){

                function retirarCaracteres($txt){
                    $txt = str_replace(".", "", $txt);
                    $txt = str_replace(",", "", $txt);
                    $txt = str_replace("/", "", $txt);
                    $txt = str_replace("-", "", $txt);

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

                $codificacao_referencia = gerar_senha(5, true, true, true, false);
                $GLOBALS['Referencia']  = "REF" . date("dmYHis") . $codificacao_referencia . "";

                global $Referencia;

                $nome                   = mysql_real_escape_string($_POST["pagador_nome"]);
                $sexo                   = $_POST["sexo"];
                $data_formatada         = explode("/", $_POST["pagador_dt_nascimento"]);
                $pagador_dt_nascimento  = $data_formatada[2]."-".$data_formatada[1]."-".$data_formatada[0];
                $cpf                    = retirarCaracteres(mysql_real_escape_string($_POST["pagador_cpf"]));
                $rg                     = retirarCaracteres(mysql_real_escape_string($_POST["pagador_rg"]));
                $telefone               = retirarCaracteres(mysql_real_escape_string($_POST["pagador_tel_cel"]));
                $email                  = mysql_real_escape_string($_POST["pagador_email"]);
                $cep                    = retirarCaracteres(mysql_real_escape_string($_POST["pagador_cep"]));
                $endereco               = mysql_real_escape_string($_POST["pagador_endereco"]);
                $numero                 = mysql_real_escape_string($_POST["pagador_numero"]);
                $complemento            = mysql_real_escape_string($_POST["pagador_complemento"]);
                $bairro                 = mysql_real_escape_string(utf8_decode($_POST["pagador_bairro"]));
                $cidade                 = mysql_real_escape_string($_POST["pagador_cidade"]);
                $estado                 = mysql_real_escape_string($_POST["pagador_estado"]);
                $bilhetes               = $_POST['bilhetes'];
                $id_evento              = $_POST['evento'];

                if (empty($_POST['delivery'])) {
                    $delivery = 'N';
                } else {
                    $delivery = $_POST['delivery'];
                }

                foreach ($bilhetes as $key) {
                    if (!empty($key["bilhete"])) {
                        $sql_ingressosu = mysql_query("SELECT i.*,
                            it.descricao as tipo_ingresso
                            FROM _S_V_ingressos as i
                            LEFT JOIN _S_V_ingressos_tipo as it ON it.id = i.id_ingressos_tipo
                            WHERE i.id =  " . $key['bilhete'] . " ");
                        $dados_ingressoi = mysql_fetch_array($sql_ingressosu);

                        $produtosTransacao .= "Desc.:" . $dados_ingressoi["descricao"] . " " . $dados_ingressoi["genero"] . " " . $dados_ingressoi["tipo_ingresso"] . " - Lote: " . $dados_ingressoi["lote"] . " - Qtd.: " . $key['quantidade'] . " - Preço: " . $dados_ingressoi['preco'] . " || ";
                        $valorTotal += $dados_ingressoi['preco'] * $key['quantidade'];
                    }
                }

                $sql_id_transacao = mysql_query("SELECT MAX(id)+1 as maxID FROM _S_V_transacoes");
                $dados_id_transacao = mysql_fetch_array($sql_id_transacao);
                global $Referencia;

                $directPaymentRequest = new PagSeguroDirectPaymentRequest();
                $directPaymentRequest->setPaymentMode('DEFAULT');

                // Nova Implementação
                // 24 de FEV de 2017
                // Ederson Rodrigues

                //PEGAR NOTIFICACAO E ENVIAR VOUCHER VIA POST PARA SERVIDOR SMTP
                $nome                   = $nome;
                $email                  = $email;
                $referencia             = $Referencia;
                $assunto                = "Compra Realizada";
                $email_empresa          = "contato@ingressosrecife.com";
                $email_contratante      = "oiromildojunior@yahoo.com.br";
                $empresa                = "IngressosRecife";
                $dominio                = "www.ingressosrecife.com";

                $dados_smtp = array(
                    "id"                =>$id,
                    "nome"              =>$nome,
                    "email"             =>$email,
                    "referencia"        =>$referencia,
                    "assunto"           =>$assunto,
                    "email_empresa"     =>$email_empresa,
                    "email_contratante" =>$email_contratante,
                    "empresa"           =>$empresa,
                    "dominio"           =>$dominio
                );

                $url = "http://smtp.rota3.com.br/post_pagamento.php";

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

                $directPaymentRequest->setNotificationURL('https://www.ingressosrecife.com/payment/notificacao.php');
                $directPaymentRequest->setCurrency("BRL");

                foreach ($bilhetes as $key2) {
                    if (!empty($key2["bilhete"])) {
                        $sql_ingressos = mysql_query("SELECT i.*,
                            it.descricao as tipo_ingresso
                            FROM _S_V_ingressos as i
                            LEFT JOIN _S_V_ingressos_tipo as it ON it.id = i.id_ingressos_tipo
                            WHERE i.id = " . $key2['bilhete'] . " ");
                        $dados_ingresso = mysql_fetch_array($sql_ingressos);
                        $dados_ingresso['preco'] = str_replace(",", ".", $dados_ingresso['preco']);
                        $directPaymentRequest->addItem($key2['bilhete'], $dados_ingresso['descricao'] . " " . $dados_ingresso['genero'] . " " . $dados_ingresso['tipo_ingresso'], $key2['quantidade'], number_format($dados_ingresso['preco'], 2));
                        $valorTotal_p_conveniencia += $dados_ingresso['preco'] * $key2['quantidade'];
                    }
                }

                //ADICIONAR PREÇO DE CONVENIENCIA
                $sql_evento_conveniencia = mysql_query("SELECT * FROM _S_V_eventos WHERE id = '" . $id_evento . "' ");
                $dados_evento_conveniencia = mysql_fetch_array($sql_evento_conveniencia);

                $tx_conveniencia = ($valorTotal_p_conveniencia * $dados_evento_conveniencia['taxa_conveniencia']) / 100;
                $directPaymentRequest->addItem('0001', 'Taxa de Conveniencia', 1, number_format($tx_conveniencia,2));

                //ADICIONAR PREÇO DE DELIVERY
                if ($_POST['delivery'] == 'S') {
                    $sql_conveniencia = mysql_query("SELECT * FROM _S_V_configuracoes_taxas WHERE id = 1");
                    $dados_conveniencia = mysql_fetch_array($sql_conveniencia);

                    $tx_delivery = $dados_conveniencia['taxa_delivery'];
                    $directPaymentRequest->addItem('0002', 'Taxa de Delivery', 1, $tx_delivery);
                }

                if ($_POST['delivery'] == 'N') {
                    $produtosTransacao .= " Sem delivery ";
                }
                if ($_POST['delivery'] == 'TrocaVoucher'){
                    $produtosTransacao .= "Troca de Voucher em Local Especificado";
                }
                if ($_POST['delivery'] == 'RetiraLoja'){
                    $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping Tacaruna";
                }
                if ($_POST['delivery'] == 'RetiraLoja2'){
                    $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping RioMar";
                }
                if ($_POST['delivery'] == 'RetiraLoja3'){
                    $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping Boa Vista";
                }
                if ($_POST['delivery'] == 'RetiraLoja4'){
                    $produtosTransacao .= "Retirada de Ingresso no Plaza Shopping";
                }
                if ($_POST['delivery'] == 'RetiraBil'){
                    $produtosTransacao .= "Troca na Bilheteria do Evento";
                }
                $directPaymentRequest->setReference($Referencia);

                // Sets shipping information for this payment request
                $CODIGO_SEDEX = PagSeguroShippingType::getCodeByType('SEDEX');
                $directPaymentRequest->setShippingType($CODIGO_SEDEX);
                $directPaymentRequest->setShippingAddress($cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, 'BRA');


                // Sets your customer information.
                //$paymentRequest->setSender('João Comprador', 'comprador@uol.com.br', '11', '56273440');
                $directPaymentRequest->setSender($nome, $email, $ddd, $telefone,'CPF',$cpf);
                //$directPaymentRequest->setRedirectUrl("http://www.ingressosrecife.com/");

                try {
                    $credentials = new PagSeguroAccountCredentials("sacingressosrecife@gmail.com","79F4ECC023CE4FCA87F7AD553916063B");

                    $directPaymentRequest->setSenderHash( $_POST['user_token']);
                    $redirecionar = true;

                    if ($_POST['boleto']){
                        $directPaymentRequest->setPaymentMethod('BOLETO');
                    } elseif ($_POST['credito']){
                        $redirecionar = false;

                        $valor = ($_POST['parcelas'] == 1)?  number_format($dados_ingresso['preco']+ $tx_conveniencia, 2) :$dados_ingresso['preco'] ;
                        $directPaymentRequest->setPaymentMethod('CREDIT_CARD');
                        $installments = new PagSeguroInstallment(
                            array(
                                'quantity' =>$_POST['parcelas'],
                                'value' =>  number_format($_POST['valor_parcela'], 2, '.', '')
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
                                        'birthDate'     =>date('d/m/Y', strtotime($data_nascimento)) ,
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
                    else{
                        $directPaymentRequest->setPaymentMethod('EFT');
                        $directPaymentRequest->setOnlineDebit(
                            array(
                                "bankName"              =>$_POST['banco']
                            )
                        );
                    }

                    $credentials = PagSeguroConfig::getAccountCredentials();
                    $url = $directPaymentRequest->register($credentials);

                    self::printPaymentUrl($url, $redirecionar);

                } catch (PagSeguroServiceException $e) {
                    echo json_encode(array('success'=>false,'message'=>$e->getMessage()) );
                }
            }

            public static function printPaymentUrl($url, $boleto = false){
                if ($url) {

                    $nome                   = mysql_real_escape_string($_POST["pagador_nome"]);
                    $sexo                   = $_POST["sexo"];
                    $data_formatada         = explode("/", $_POST["pagador_dt_nascimento"]);
                    $pagador_dt_nascimento  = $data_formatada[2]."-".$data_formatada[1]."-".$data_formatada[0];
                    $cpf                    = retirarCaracteres(mysql_real_escape_string($_POST["pagador_cpf"]));
                    $rg                     = retirarCaracteres(mysql_real_escape_string($_POST["pagador_rg"]));
                    $telefone               = retirarCaracteres(mysql_real_escape_string($_POST["pagador_tel_cel"]));
                    $email                  = mysql_real_escape_string($_POST["pagador_email"]);
                    $cep                    = retirarCaracteres(mysql_real_escape_string($_POST["pagador_cep"]));
                    $endereco               = mysql_real_escape_string($_POST["pagador_endereco"]);
                    $numero                 = mysql_real_escape_string($_POST["pagador_numero"]);
                    $complemento            = mysql_real_escape_string($_POST["pagador_complemento"]);
                    $bairro                 = mysql_real_escape_string($_POST["pagador_bairro"]);
                    $cidade                 = mysql_real_escape_string($_POST["pagador_cidade"]);
                    $estado                 = mysql_real_escape_string($_POST["pagador_estado"]);
                    $bilhetes               = $_POST['bilhetes'];
                    $cod_comissario         = $_POST['txtcomissario'];
                    $id_evento              = $_POST['evento'];


                    if ($_POST['delivery'] == 'N') {
                        $delivery = 'N';
                    }
                    if ($_POST['delivery'] == 'S') {
                        $delivery = $_POST['delivery'];
                    }
                    if ($_POST['delivery'] == 'TrocaVoucher'){
                        $delivery = "Troca de Voucher em Local Especificado";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja'){
                        $delivery = "Retirada de Ingresso na Loja";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja2'){
                        $delivery = "Retirada de Ingresso na Loja Riachuelo do Shopping RioMar";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja3'){
                        $delivery = "Retirada de Ingresso na Loja Riachuelo do Shopping Boa Vista";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja4'){
                        $produtosTransacao .= "Retirada de Ingresso no Plaza Shopping";
                    }
                    if ($_POST['delivery'] == 'RetiraBil'){
                        $delivery = "Troca na Bilheteria do Evento";
                    }

                    $ddd_celular            = $_POST['ddd_celular'];
                    $telefone_celular       = $_POST['pagador_tel_cel'];
                    $CartaoNome             = $_POST['cartaoNome'];
                    $CartaoCPF              = $_POST['cartaoCPF'];
                    $CartaoEmail            = $_POST['cartaoEMAIL'];
                    $cartaoRG               = $_POST['cartaoRG'];

                    global $Referencia;



                    foreach ($bilhetes as $key3) {
                        if (!empty($key3["bilhete"])) {
                            $sql_ingressosi = mysql_query("SELECT i.*,
                                it.descricao as tipo_ingresso
                                FROM _S_V_ingressos as i
                                LEFT JOIN _S_V_ingressos_tipo as it ON it.id = i.id_ingressos_tipo
                                WHERE i.id =  " . $key3['bilhete'] . " ");
                            $dados_ingressoi = mysql_fetch_array($sql_ingressosi);

                            $ID_ingressos .= $key3['bilhete'] . ", ";

                            $produtosTransacao .= "Desc.:" . $dados_ingressoi["descricao"] . " " . $dados_ingressoi["genero"] . " " . $dados_ingressoi["tipo_ingresso"] . " - Lote: " . $dados_ingressoi["lote"] . " -  Qtd.: " . $key3['quantidade'] . " - Preço: " . $dados_ingressoi['preco'] . " || ";
                            $valorTotal += $dados_ingressoi['preco'] * $key3['quantidade'];
                        }
                    }


                    //ADICIONAR PREÇO DE CONVENIENCIA
                    $sql_evento_conveniencia = mysql_query("SELECT * FROM _S_V_eventos WHERE id = '" . $id_evento . "' ");
                    $dados_evento_conveniencia = mysql_fetch_array($sql_evento_conveniencia);

                    $tx_conveniencia = ($valorTotal * $dados_evento_conveniencia['taxa_conveniencia']) / 100;
                    $produtosTransacao .= " Valor da Conveniência: " . $tx_conveniencia . " ||";
                    $valorTotal += $tx_conveniencia;

                    if ($_POST['delivery'] == 'S') {
                        $sql_conveniencia = mysql_query("SELECT * FROM _S_V_configuracoes_taxas WHERE id = 1");
                        $dados_conveniencia = mysql_fetch_array($sql_conveniencia);

                        $tx_delivery = $dados_conveniencia['taxa_delivery'];
                        $produtosTransacao .= " Valor do Delivery:  R$ " . $tx_delivery . "";
                        $valorTotal += $tx_delivery;
                    }

                    if ($_POST['delivery'] == 'N') {
                        $produtosTransacao .= "Sem delivery ";
                    }
                    if ($_POST['delivery'] == 'TrocaVoucher'){
                        $produtosTransacao .= "Troca de Voucher em Local Especificado ";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja'){
                        $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping Tacaruna";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja2'){
                        $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping RioMar";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja3'){
                        $produtosTransacao .= "Retirada de Ingresso na Loja Riachuelo do Shopping Boa Vista";
                    }
                    if ($_POST['delivery'] == 'RetiraLoja4'){
                        $produtosTransacao .= "Retirada de Ingresso no Plaza Shopping";
                    }
                    if ($_POST['delivery'] == 'RetiraBil'){
                        $produtosTransacao .= "Troca na Bilheteria do Evento";
                    }

                    $sql_id_transacao = mysql_query("SELECT MAX(id)+1 as maxID FROM _S_V_transacoes");
                    $dados_id_transacao = mysql_fetch_array($sql_id_transacao);
                    global $Referencia;


                    $inserir_transacao = mysql_query("INSERT INTO _S_V_transacoes(
                        CliNome,
                        CliEmail,
                        CliEndereco,
                        CliNumero,
                        CliComplemento,
                        CliBairro,
                        CliCidade,
                        CliEstado,
                        CliCEP,
                        CliDDD,
                        CliTelefone,
                        CliTelefoneCompleto,
                        CliCPF,
                        CliRG,
                        CliDataNascimento,
                        CliSexo,
                        totalValor,
                        Referencia,
                        itens,
                        delivery,
                        id_evento,
                        ProdID,
                        CliCelular,
                        CartaoNome,
                        CartaoCPF,
                        CartaoEmail,
                        CartaoRG,
                        StatusTransacao) VALUES(
                        '" . $nome . "',
                        '" . $email . "',
                        '" . $endereco . "',
                        '" . $numero . "',
                        '" . $complemento . "',
                        '" . $bairro . "',
                        '" . $cidade . "',
                        '" . $estado . "',
                        '" . $cep . "',
                        '" . $ddd . "',
                        '" . $telefone . "',
                        '" . $ddd . " " . $telefone . "',
                        '" . $cpf . "',
                        '" . $rg . "',
                        '" . $data_nascimento . "',
                        '" . $sexo . "',
                        '" . $valorTotal . "',
                        '" . $Referencia . "',
                        '" . $produtosTransacao . "',
                        '" . $delivery . "',
                        '" . $id_evento . "',
                        '" . $ID_ingressos . "',
                        '" . $ddd_celular . " " . $telefone_celular . "',
                        '" . $CartaoNome . "',
                        '" . $CartaoCPF . "',
                        '" . $CartaoEmail . "',
                        '" . $cartaoRG . "',
                        'Aguardando PagSeguro')");




                    // CLIENTES
                    $sql_verif_cliente = mysql_query("SELECT * FROM _S_clientes WHERE CliCPF = '" . $cpf . "'");
                    if (mysql_num_rows($sql_verif_cliente) <= 0) {
                        $inserir_cliente = mysql_query("INSERT INTO _S_clientes(
                        CliNome,
                        CliEmail,
                        CliEndereco,
                        CliNumero,
                        CliComplemento,
                        CliBairro,
                        CliCidade,
                        CliEstado,
                        CliCEP,
                        CliDDD,
                        CliTelefone,
                        CliTelefoneCompleto,
                        CliCPF,
                        CliRG,
                        CliDataNascimento,
                        CliSexo,
                        CliCelular) VALUES(
                        '" . $nome . "',
                        '" . $email . "',
                        '" . $endereco . "',
                        '" . $numero . "',
                        '" . $complemento . "',
                        '" . $bairro . "',
                        '" . $cidade . "',
                        '" . $estado . "',
                        '" . $cep . "',
                        '" . $ddd . "',
                        '" . $telefone . "',
                        '" . $ddd . " " . $telefone . "',
                        '" . $cpf . "',
                        '" . $rg . "',
                        '" . $data_nascimento . "',
                        '" . $sexo . "',
                        '" . $ddd_celular . " " . $telefone_celular . "')");
                    }

                    foreach ($bilhetes as $key4) {
                        $sql_verif_comissario = mysql_query("SELECT * FROM _S_V_comissario WHERE cod_comissario = '" . $cod_comissario . "'");
                        if (mysql_num_rows($sql_verif_comissario) > 0) {
                            if (!empty($key4["bilhete"])) {
                                mysql_query("INSERT INTO _S_V_comissario_vendas(referencia, id_comissario, id_evento, id_ingresso, quantidade) VALUES('" . $Referencia . "','" . $cod_comissario . "','" . $id_evento . "','" . $key4["bilhete"] . "','" . $key4["quantidade"] . "')");
                            }
                        } else {
                            $cod_comissario = '';
                        }

                        $sql_ingressos_ = mysql_query("SELECT * FROM _S_V_ingressos WHERE id = " . $key4['bilhete'] . " ");
                        @$dados_ingresso_ = mysql_fetch_array($sql_ingressos_);

                        if (!empty($dados_ingresso_["descricao"])) {
                            mysql_query("INSERT INTO _S_V_transacoes_produtos
                                (Referencia,cod_comissario,ProdID,ProdDescricao,ProdValor,ProdQuantidade,ProdLote) VALUES('" . $Referencia . "','" . $cod_comissario . "','" . $key4["bilhete"] . "','" . $dados_ingresso_["descricao"] . "','" . $dados_ingresso_["preco"] . "','" . $key4["quantidade"] . "','" . $dados_ingresso_["lote"] . "')");
                        }
                    }
                    if($boleto){
                        echo "<script type='text/javascript'>window.location.href='" . $url->getPaymentLink(). "';</script>";
                    }else{
                        echo json_encode(array('success'=>true));
                    }
                }
            }

        }
        createPaymentRequest::main();
    }

    echo "<pre>";
    print_r($_REQUEST);
    echo "</pre>";

    // break;
    ?>

    <?php if(!$_POST['credito']):?>

</body>

<?php endif?>