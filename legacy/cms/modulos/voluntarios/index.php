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
                $sql = "SELECT * FROM _voluntarios_intro WHERE ativo = 'S' ORDER BY id DESC LIMIT 1";
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
                        <li><a href="modulos/voluntarios/intro/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip uk-icon="icon: file-edit"></a></li>
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


<h3 class="uk-heading-line"><span>Voluntários &bull; Cadastros</span></h3>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-width-small">Telefone</th>
                <th class="uk-width-small">Ministerio</th>
                <th class="uk-width-small">Membro</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql_second = "SELECT * FROM _voluntarios ORDER BY id DESC";
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
                <td class="uk-text-nowrap" width="26%"><?php echo $dados_doacoes['telefone']; ?></td>
                <td class="uk-text" width="36%">
                    <?php

                    $tag_ex = explode(", ",substr($dados_doacoes['ministerio'],0,-2));
                    for($t = 0; $t < count($tag_ex); $t++) {
                        echo "<i class='fa fa-tag'></i> " . $tag_ex[$t]."<br>";
                    }
                    ?>
                </td>
                <td class="uk-text-truncate" align="center">
                    <?php if ($dados['membro'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
                    <?php if ($dados['membro'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td class="uk-text-nowrap"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados_doacoes['data']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-nowrap" width="6%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/voluntarios/view.php?id=<?php echo $dados_doacoes['id'];?>" title="Ver Detalhes" uk-tooltip uk-icon="icon: list"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>