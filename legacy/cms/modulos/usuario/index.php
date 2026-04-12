<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



USUARIOS



-->


<h3 class="uk-heading-line"><span>Usuários</span></h3>

<?php if ($_SESSION['nivel'] == 1) {?>
<div class="pull-right">
	<a href="modulos/usuario/cadastrar" class="uk-button uk-button-success uk-button-small" title="Novo Registro" uk-tooltip>
		<span uk-icon="icon: plus-circle"></span>
	</a>
</div>
<?php } ?>

<div class="clearfix"></div>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-table-shrink">Login</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-width-small">Ativo</th>
                <th class="uk-width-small">Permissão</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
        	<?php
	        	if ($_SESSION['nivel'] == 1) {
	        		$sql = "SELECT * FROM _usuarios_cms order by id DESC";
	        	} else {
	        		$sql = "SELECT * FROM _usuarios_cms WHERE ativo = 'S' AND id = ".$_SESSION['id']." order by id ASC";
	        	}
				$bd->consulta($sql);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados = $bd->getDados();
			?>
            <tr id="tr_<?php echo $dados['id'];?>">
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-table-link" width="20%">
                    <?php echo $dados['nome']; ?>
                </td>
                <td class="uk-table-link" width="20%"><?php echo $dados['email']; ?></td>
                <td class="uk-text-nowrap" width="15%"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados['data_criacao']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-truncate">
                	<?php if ($dados['ativo'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
					<?php if ($dados['ativo'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td><?php if ($dados['permissao'] == 1) {echo "Administrador";}?></td>
                <td class="uk-text-nowrap" width="12%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/usuario/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip href="#" uk-icon="icon: file-edit"></a></li>
                        <?php if ($_SESSION['nivel'] == 1) {?>
                        <li><a href="javascript:void();" data-id="<?php echo $dados['id'];?>" class="deletar" title="Excluir" uk-tooltip uk-icon="icon: trash"></a></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>

<script>

    function deletar(id){
        $.confirm({
            icon: 'fa fa-cog fa-spin',
            title: 'Excluir',
            content: 'Tem certeza que deseja excluir?',
            autoClose: 'cancelAction|6000',
            animation: 'zoom',
            closeAnimation: 'scale',
            type: 'red',
            typeAnimated: true,
            buttons: {
                deleteUser: {
                    text: 'Sim',
                    btnClass: 'btn-red',
                    action: function () {
                        $.ajax({
                            url: 'modulos/usuario/excluir.php',
                            type: 'POST',
                            data:{
                                id: id
                            },
                            success: function(response)
                            {
                                if(!response.error){
                                    $('#tr_'+id).fadeOut('slow');
                                    UIkit.notification({
                                        message: '<span uk-icon="icon: check"></span> Excluído com sucesso!',
                                        status: 'success',
                                        pos: 'top-center',
                                        timeout: 5000
                                    });
                                }else{
                                    UIkit.notification({
                                        message: '<span uk-icon="icon: close"></span> Erro ao excluir. Tente novamente!',
                                        status: 'danger',
                                        pos: 'top-center',
                                        timeout: 5000
                                    });
                                }
                            },
                            error: function(xhr)
                            {
                                alert(xhr.responseText);
                            }
                        });
                    }
                },
                cancelAction: function () {
                    UIkit.notification({
                        message: '<span uk-icon="icon: warning"></span> Ação cancelada!',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }
            }
        });

    }

    $(function(){
        $(document).on('click','.deletar',function(){
            deletar($(this).data('id'));
            return false;
        });
    });

</script>