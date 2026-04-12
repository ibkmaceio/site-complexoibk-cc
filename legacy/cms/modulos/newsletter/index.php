<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



NEWSLETTER



-->


<h3 class="uk-heading-line"><span>NEWSLETTER</span></h3>

<div class="pull-right">
    <a href="modulos/newsletter/exportar.php?id=<?php echo $dados['id'];?>" class="uk-button uk-button-success uk-button-small" title="Exportar - Excel" uk-tooltip>
        <span uk-icon="icon: cloud-download"></span>
    </a>
</div>

<div class="clearfix"></div>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-width-small">Email</th>
                <th class="uk-width-small">Data do Cadastro</th>
            </tr>
        </thead>
        <tbody>
        	<?php

			$quantidade = 25;
			//a pagina atual
			$pagina     = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
			//Calcula a pagina de qual valor será exibido
			$inicio     = ($quantidade * $pagina) - $quantidade;

			//Monta o SQL com LIMIT para exibição dos dados
			$sql = "SELECT * FROM _newsletter ORDER BY id DESC LIMIT $inicio, $quantidade";
			//Executa o SQL
			$qr  = mysql_query($sql) or die(mysql_error());
			//Percorre os campos da tabela
			while($dados = mysql_fetch_assoc($qr)){
			?>
            <tr>
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-preserve-width" width="45%"><?php echo $dados['nome']; ?></td>
                <td class="uk-preserve-width" width="35%"><?php echo $dados['email']; ?></td>
                <td class="uk-text-nowrap" width="35%"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados['data']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>