<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



CONTATOS



-->


<h3 class="uk-heading-line"><span>Contatos</span></h3>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-width-small">Assunto</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-width-small">Status</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
        	<?php
	        	$sql = "SELECT * FROM _contatos order by id DESC";
				$bd->consulta($sql);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados = $bd->getDados();
			?>
            <tr>
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-text-nowrap" width="40%">
                    <?php echo $dados['nome']; ?>
                    <span><a href="mailto:<?php echo $dados['email']; ?>"><span uk-icon="icon: arrow-right"></span> <?php echo $dados['email']; ?></a></span>
                </td>
                <td class="uk-text-nowrap"><?php echo $dados['assunto']; ?></td>
                <td class="uk-text-nowrap"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados['data_contato']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-truncate">
                	<?php if ($dados['status'] == 'Pendente') echo '<span uk-icon="icon: future" title="Pendente" uk-tooltip></span> Pendente'; ?>
					<?php if ($dados['status'] == 'Respondido') echo '<span uk-icon="icon: check" title="Respondido" uk-tooltip></span> Respondido'; ?>
                </td>
                <td class="uk-text-nowrap" width="6%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/contatos/responder.php?id=<?php echo $dados['id'];?>" title="Ver Contato" uk-tooltip uk-icon="icon: info"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>