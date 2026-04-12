<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>


<!--



DOACOES



-->

<h3 class="uk-heading-line"><span>Introdução</span></h3>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-expand">Titulo</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-width-small">Ativo</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM _doacoes_intro WHERE ativo = 'S' ORDER BY id DESC LIMIT 1";
                $bd->consulta($sql);
                $bd->first();
                $row = $bd->getRows();

                for($i=1; $i<=$row; $i++){
                $dados = $bd->getDados();
            ?>
            <tr>
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-text-nowrap">
                    <?php echo $dados['titulo']; ?>
                </td>
                <td class="uk-text-nowrap" width="15%"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados['data_criacao']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-truncate">
                    <?php if ($dados['ativo'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
                    <?php if ($dados['ativo'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td class="uk-text-nowrap" width="6%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/doacoes/intro/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip uk-icon="icon: file-edit"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>




<!--



DOACOES > LIST



-->


<h3 class="uk-heading-line"><span>Doações</span></h3>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-width-small">Modalidade</th>
                <th class="uk-width-small">Tipo</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql_second = "SELECT * FROM _doacoes ORDER BY id DESC";
                $bd->consulta($sql_second);
                $bd->first();
                $row = $bd->getRows();

                for($i=1; $i<=$row; $i++){
                $dados_doacoes = $bd->getDados();
            ?>
            <tr>
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-text-nowrap" width="40%">
                    <?php echo $dados_doacoes['nome']; ?>
                    <span><a href="mailto:<?php echo $dados_doacoes['email']; ?>"><br><span uk-icon="icon: mail"></span> <?php echo $dados_doacoes['email']; ?></a></span>
                </td>
                <td class="uk-text-nowrap" width="26%"><?php echo $dados_doacoes['modalidade']; ?></td>
                <td class="uk-text" width="36%">
                    <?php

                    if ($dados_doacoes['tipo'] == NULL) {

                        if ($dados_doacoes['TipoPagamento'] == "Boleto") {
                            echo "<i class='fa fa-barcode' title='Boleto' uk-tooltip></i>";
                        }

                        if (utf8_decode($dados_doacoes['TipoPagamento']) == "Cartão de Crédito") {
                            echo "<i class='fa fa-credit-card' title='Cartão de Crédito' uk-tooltip></i>";
                        }

                        if (utf8_decode($dados_doacoes['TipoPagamento']) == "Transferência online") {
                            echo "<i class='fas fa-arrows-alt-h' title='Transferência Online - Débito' uk-tooltip></i>";
                        }

                        if ($dados_doacoes['TipoPagamento'] == "Boleto Parcelado") {
                            echo "<i class='fa fa-barcode' title='Boleto' uk-tooltip></i>";
                        }
                    }

                    else {

                        $tag_ex = explode(", ",substr($dados_doacoes['tipo'],0,-2));
                        for($t = 0; $t < count($tag_ex); $t++) {
                            echo "<i class='fa fa-tag'></i> " . $tag_ex[$t]."<br>";
                        }
                    }

                    echo "<br>";
                    if ($dados_doacoes['StatusTransacao'] == 'Aprovado') {
                        echo "<span class='status_A'><i class='far fa-check-circle'></i> Aprovado</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'Completo') {
                        echo "<span class='status_A'><i class='far fa-check-circle'></i> Completo</span>";
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'PAID') {
                        echo "<span class='status_A'><i class='far fa-check-circle'></i> Pago</span>";
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'Cancelado') {
                        echo "<span class='status_C'><i class='far fa-times-circle'></i> Cancelado</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'Aguardando Pagto') {
                        echo "<span class='status_B'><i class='far fa-clock'></i> Aguardando Pagto</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'Aguardando PagSeguro') {
                        echo "<span class='status_B'><i class='far fa-clock'></i> Aguardando Pagseguro</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'PagSeguro') {
                        echo "<span class='status_B'><i class='far fa-clock'></i> PagSeguro</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if (utf8_decode($dados_doacoes['StatusTransacao']) == 'Em Análise') {
                        echo "<span class='status_B'><i class='far fa-clock'></i> Em Análise</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }

                    if ($dados_doacoes['StatusTransacao'] == 'Devolvido') {
                        echo "<span class='status_C'><i class='fas fa-hand-holding-usd'></i> Devolvido</span>";
                        echo "<br>";
                        echo "R$ " . number_format($dados_doacoes['totalValor'],2, ',','.');
                    }
                    ?>
                </td>
                <td class="uk-text-nowrap"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados_doacoes['data']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-nowrap" width="6%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/doacoes/view.php?id=<?php echo $dados_doacoes['id'];?>" title="Ver Detalhes" uk-tooltip uk-icon="icon: list"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>