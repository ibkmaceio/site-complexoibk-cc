<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



DESTAQUES



-->


<h3 class="uk-heading-line"><span>Banner Rotativo</span></h3>

<div class="pull-right">
    <a href="modulos/banner-rotativo/cadastrar" class="uk-button uk-button-success uk-button-small" title="Novo Registro" uk-tooltip>
        <span uk-icon="icon: plus-circle"></span>
    </a>
</div>

<div class="pull-right">
    <a href="modulos/banner-rotativo/categoria" class="uk-button uk-button-primary uk-button-small" title="Gerenciar Categorias" uk-tooltip>
		<span uk-icon="icon: settings"></span>
	</a>
</div>

<div class="clearfix"></div>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-width-small"></th>
                <th class="uk-width-small">Titulo</th>
                <th class="uk-width-small">Link</th>
                <th class="uk-width-small">Categoria</th>
                <th class="uk-width-small">Data</th>
                <th class="uk-width-small">Tipo</th>
                <th class="uk-width-small">Ativo</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
        	<?php
	        	$sql = "SELECT * FROM _destaques order by id DESC";
				$bd->consulta($sql);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados = $bd->getDados();
			?>
            <tr id="tr_<?php echo $dados['id'];?>">
                <td><input class="uk-checkbox" type="checkbox"></td>
                <td>
                    <?php

                    if ($dados['img'] == null) {
                        echo "<img src='./timthumb.php?src=".$dados['imagem_hd']."&w=65&h=65' class='uk-preserve-width uk-border-circle' />";
                    } else {
                        echo "<img src='./timthumb.php?src=./cms/assets/uploads/_DESTAQUES/".$dados['img']."&w=65&h=65' class='uk-preserve-width uk-border-circle' />";
                    }

                    ?>
                </td>
                <td class="uk-text-truncat" width="45%">
                    <?php echo $dados['titulo']; ?>
                </td>
                <td class="uk-text-nowrap" width="15%">

                    <?php

                    if ($dados['img'] == null) {
                        echo '<span uk-icon="icon: link"></span> <a href="#modal-video-'.$dados['id'].'" uk-toggle> '.$dados['embed'].'</a>';
                    } else {
                        echo '<a href="'.$dados['link_imagem'].'" target="_blank"><span uk-icon="icon: link"></span></a>';
                    }

                    ?>
                </td>

                <td class="uk-text-nowrap" width="15%">
                    <span uk-icon="icon: tag"></span>
                    <?php echo $dados['categoria_destaque']; ?>
                </td>
                <td class="uk-text-nowrap" width="5%"><span uk-icon="icon: calendar"></span> <?php $data_mysql = $dados['data_hora']; $timestamp = strtotime($data_mysql); echo date('d/m/Y', $timestamp); ?> </td>
                <td class="uk-text-truncate">
                	<?php if ($dados['tipo_destaque'] == 'I') echo '<span uk-icon="icon: image"></span>'; ?>
					<?php if ($dados['tipo_destaque'] == 'V') echo '<span uk-icon="icon: play-circle"></span>'; ?>
                </td>
                <td class="uk-text-truncate">
                	<?php if ($dados['ativo'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
					<?php if ($dados['ativo'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td class="uk-text-nowrap" width="40%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/banner-rotativo/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip href="#" uk-icon="icon: file-edit"></a></li>
                        <li><a href="javascript:void();" data-id="<?php echo $dados['id'];?>" class="deletar" title="Excluir" uk-tooltip uk-icon="icon: trash"></a></li>
                    </ul>
                </td>
            </tr>

            <div id="modal-video-<?php echo $dados['id'];?>" uk-modal="center: true">
            	<div class="uk-modal-dialog">
            		<button class="uk-modal-close-outside" type="button" uk-close></button>
            		<iframe width="100%" height="415" src="https://www.youtube.com/embed/<?php echo $dados['embed']; ?>" frameborder="0" allowfullscreen></iframe>
            	</div>
            </div>
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
                            url: 'modulos/banner-rotativo/excluir.php',
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
