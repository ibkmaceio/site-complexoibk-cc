<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



TAGS



-->

<h3 class="uk-heading-line"><span>Categorias</span></h3>

<div class="pull-right">
    <a href="javascript:history.go(-1)" title="Voltar" class="uk-button uk-button-danger uk-button-small" uk-tooltip uk-icon="icon: chevron-left"></a>
    <a href="modulos/lideranca/categoria/cadastrar" class="uk-button uk-button-success uk-button-small pull-right" title="Novo Registro" uk-tooltip>
      <span uk-icon="icon: plus-circle"></span>
  </a>
</div>

<div class="clearfix"></div>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink">Nome</th>
                <th class="uk-width-small">Slug</th>
                <th class="uk-width-small">Ativo</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
        	<?php
	        	$sql = "SELECT * FROM _lideranca_categoria order by id DESC";
				$bd->consulta($sql);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados = $bd->getDados();
			?>
            <tr id="tr_<?php echo $dados['id'];?>">
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td class="uk-table-link" width="35%">
                    <?php echo $dados['titulo']; ?>
                </td>
                <td class="uk-table-link" width="20%"><?php echo $dados['slug']; ?></td>
                <td class="uk-text-truncate">
                	<?php if ($dados['ativo'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
					<?php if ($dados['ativo'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td class="uk-text-nowrap" width="12%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/lideranca/categoria/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip href="#" uk-icon="icon: file-edit"></a></li>
                        <li><a href="javascript:void();" data-id="<?php echo $dados['id'];?>" class="deletar" title="Excluir" uk-tooltip uk-icon="icon: trash"></a></li>
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
                            url: 'modulos/lideranca/categoria/excluir.php',
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