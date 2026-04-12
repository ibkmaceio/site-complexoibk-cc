<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



CONTATOS



-->

<?php

$sql = "SELECT * FROM _doacoes WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($sql);
$bd->first();
$dados = $bd->getDados();

?>

<style>
    label.label-success {
        font-size: 12px;
        padding-top: 4px;
        font-weight: bold;
        text-transform: uppercase;
    }

    label.label-default {
        font-size: 12px;
        padding-top: 4px;
        border:1px solid #ccc;
        color: #999;
        background: #fff;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 10px;
    }
</style>

<h3 class="uk-heading-line"><span>Doações</span></h3>
<a href="javascript:history.go(-1)" title="Voltar" class="uk-button uk-button-danger pull-right" uk-tooltip uk-icon="icon: chevron-left"></a>

<div class="clearfix"></div>

<div class="uk-background-muted uk-padding">
    <form action="" method="post">
        <div class="padding">
            <h2><?php echo $dados['nome'];?></h2>
            <b>Email:</b> <?php echo $dados['email'];?> <b style="margin-left: 25px;">Telefone:</b> <?php echo $dados['telefone'];?><br><br>

            <label for="" class="label label-default">Endereço</label> <br><br>
            <strong>CEP:</strong> <?php echo $dados['cep'];?><br>
            <?php echo $dados['endereco'];?>, <?php echo $dados['numero'];?><br>
            <?php echo $dados['bairro'];?> - <?php echo $dados['cidade'];?>/<?php echo $dados['estado'];?>

            <hr>

            <div class="row">
                <div class="col-sm-4">
                    <b>Modalidade</b><br>
                    <?php echo $dados['modalidade'];?>
                </div>

                <div class="col-sm-5">
                    <b>Tipo</b><br>
                    <?php
                        if ($dados['tipo'] == NULL) {

                            if ($dados['TipoPagamento'] == "Boleto") {
                                echo "<i class='fa fa-barcode' title='Boleto' uk-tooltip></i>";
                            }

                            if (utf8_decode($dados['TipoPagamento']) == "Cartão de Crédito") {
                                echo "<i class='fa fa-credit-card' title='Cartão de Crédito' uk-tooltip></i>";
                            }

                            if (utf8_decode($dados['TipoPagamento']) == "Transferência online") {
                                echo "<i class='fas fa-arrows-alt-h' title='Transferência Online - Débito' uk-tooltip></i>";
                            }

                            if ($dados['TipoPagamento'] == "Boleto Parcelado") {
                                echo "<i class='fa fa-barcode' title='Boleto' uk-tooltip></i>";
                            }
                        }

                        else {

                            $tag_ex = explode(", ",substr($dados['tipo'],0,-2));
                            for($t = 0; $t < count($tag_ex); $t++) {
                                echo "<i class='fa fa-tag'></i> " . $tag_ex[$t]."<br>";
                            }
                        }

                        echo "<br>";
                        if ($dados['StatusTransacao'] == 'Aprovado') {
                            echo "<span class='status_A'><i class='far fa-check-circle'></i> Aprovado</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if ($dados['StatusTransacao'] == 'Completo') {
                            echo "<span class='status_A'><i class='far fa-check-circle'></i> Completo</span>";
                        }

                        if ($dados['StatusTransacao'] == 'PAID') {
                            echo "<span class='status_A'><i class='far fa-check-circle'></i> Pago</span>";
                        }

                        if ($dados['StatusTransacao'] == 'Cancelado') {
                            echo "<span class='status_C'><i class='far fa-times-circle'></i> Cancelado</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if ($dados['StatusTransacao'] == 'Aguardando Pagto') {
                            echo "<span class='status_B'><i class='far fa-clock'></i> Aguardando Pagto</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if ($dados['StatusTransacao'] == 'Aguardando PagSeguro') {
                            echo "<span class='status_B'><i class='far fa-clock'></i> Aguardando Pagseguro</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if ($dados['StatusTransacao'] == 'PagSeguro') {
                            echo "<span class='status_B'><i class='far fa-clock'></i> PagSeguro</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if (utf8_decode($dados['StatusTransacao']) == 'Em Análise') {
                            echo "<span class='status_B'><i class='far fa-clock'></i> Em Análise</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }

                        if ($dados['StatusTransacao'] == 'Devolvido') {
                            echo "<span class='status_C'><i class='fas fa-hand-holding-usd'></i> Devolvido</span>";
                            echo "<br>";
                            echo "R$ " . number_format($dados['totalValor'],2, ',','.');
                        }
                    ?>

                    <br>
                    <p>
                        <b>Transação</b> <br>
                        <?php echo $dados['Referencia']; ?>
                    </p>
                </div>

                <div class="col-sm-3">
                    <b>Forma de Entrega</b><br>
                    <label for="" class="label label-success">
                        <?php

                            if ($dados['forma_entrega'] == "Venham") {
                                echo "Venham Buscar";
                            }

                            elseif ($dados['forma_entrega'] == "Irei") {
                                echo "Irei Levar";
                            }
                            else {
                                echo "Doação";
                            }

                        ?>
                    </label>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>
    </form>

</div>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>