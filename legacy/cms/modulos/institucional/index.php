<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>


<!--



INSTITUCIONAL



-->

<h3 class="uk-heading-line"><span>Institucional</span></h3>

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
				$sql = "SELECT * FROM _institucional WHERE ativo = 'S' ORDER BY id DESC LIMIT 1";
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
                <td class="uk-text-nowrap" width="12%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/institucional/galeria/verGaleria.php?id=<?php echo $dados['id'];?>" title="Galeria de Imagens" uk-tooltip href="#" uk-icon="icon: image"></a></li>
                        <li><a href="modulos/institucional/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip uk-icon="icon: file-edit"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>







<!--



EQUIPE > INSTRODUCAO



-->

<h3 class="uk-heading-line"><span>Liderança &bull; Introdução</span></h3>

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
                $sql = "SELECT * FROM _lideranca_intro WHERE ativo = 'S' ORDER BY id DESC LIMIT 1";
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
                <td class="uk-text-nowrap" width="12%">
                    <ul class="uk-iconnav">
                        <li><a href="modulos/lideranca/intro/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip uk-icon="icon: file-edit"></a></li>
                    </ul>
                </td>
            </tr>
            <?php $bd->next(); } ?>
        </tbody>
    </table>
</div>








<!--



EQUIPE



-->

<h3 class="uk-heading-line"><span>Liderança  &bull; Equipe</span></h3>
<div class="pull-right">
	<a href="modulos/lideranca/cadastrar" class="uk-button uk-button-success uk-button-small" title="Novo Registro" uk-tooltip>
		<span uk-icon="icon: plus-circle"></span>
	</a>
</div>

<div class="pull-right">
    <a href="modulos/lideranca/categoria" class="uk-button uk-button-primary uk-button-small" title="Gerenciar Categorias" uk-tooltip>
        <span uk-icon="icon: settings"></span>
    </a>
</div>

<div class="clearfix"></div>

<div class="uk-overflow-auto uk-background-muted">
    <table class="uk-table uk-table-hover uk-table-middle">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-expand">Nome</th>
                <th class="uk-width-small">Cargo</th>
                <th class="uk-width-small">Ativo</th>
                <th class="uk-table-shrink uk-text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
        	<?php
				$sql = "SELECT * FROM _lideranca ORDER BY id DESC";
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

                    if ($dados['img'] == NULL) {
                        echo "<img src='./timthumb.php?src=./assets/img/avatar.png&w=65&h=65' class='uk-preserve-width uk-border-circle' />";
                    } else {

                    echo "<img src='./timthumb.php?src=./cms/assets/uploads/_LIDERANCA/".$dados['img']."&w=65&h=65' class='uk-preserve-width uk-border-circle' />";
                    }
                    ?>
                </td>
                <td width="45%">
                	<?php echo $dados['nome']; ?> <br>

                    <?php if ($dados['facebook'] == NULL) { } else { ?>
                	<a href="http://fb.com/<?php echo $dados['facebook'];?>" target="_blank" rel="noopener noreferrer">
                		<i class="class-social fb fa fa-facebook"></i>
                	</a>
                    <?php } ?>

                    <?php if ($dados['twitter'] == NULL) { } else { ?>
                	<a href="http://twitter.com/<?php echo $dados['twitter'];?>" target="_blank" rel="noopener noreferrer">
                		<i class="class-social tw fa fa-twitter"></i>
                	</a>
                    <?php } ?>

                    <?php if ($dados['instagram'] == NULL) { } else { ?>
                	<a href="http://instagram.com/<?php echo $dados['instagram'];?>" target="_blank" rel="noopener noreferrer">
                		<i class="class-social ig fa fa-instagram"></i>
                	</a>
                    <?php } ?>

                    <?php if ($dados['youtube'] == NULL) { } else { ?>
                	<a href="http://youtube.com/user/<?php echo $dados['youtube'];?>" target="_blank" rel="noopener noreferrer">
                		<i class="class-social youtube fa fa-youtube"></i>
                	</a>
                    <?php } ?>

                    <?php if ($dados['linkedin'] == NULL) { } else { ?>
                	<a href="http://linkedin.com/in/<?php echo $dados['linkedin'];?>" target="_blank" rel="noopener noreferrer">
                		<i class="class-social linkedin fa fa-linkedin"></i>
                	</a>
                    <?php } ?>
                </td>
                <td width="20%">
                    <?php echo $dados['titulo_categoria']; ?>
                </td>
                <td class="uk-text-truncate">
                	<?php if ($dados['ativo'] == 'S') echo '<span uk-icon="icon: check"></span>'; ?>
					<?php if ($dados['ativo'] == 'N') echo '<span uk-icon="icon: close"></span>'; ?>
                </td>
                <td class="uk-text-nowrap" width="15%">
                    <ul class="uk-iconnav">
                        <li><a title="Detalhes" uk-tooltip href="#" uk-icon="icon: info" uk-toggle="target: #modal-eye-<?php echo $dados['id']; ?>"></a></li>
                        <li><a href="modulos/lideranca/editar.php?id=<?php echo $dados['id'];?>" title="Editar" uk-tooltip uk-icon="icon: file-edit"></a></li>
                        <li><a href="javascript:void();" data-id="<?php echo $dados['id'];?>" class="deletar" title="Excluir" uk-tooltip uk-icon="icon: trash"></a></li>
                    </ul>



                    <!--

					MODAL > EQUIPE

                    -->
                    <div id="modal-eye-<?php echo $dados['id']; ?>" uk-modal>
                    	<div class="uk-modal-dialog uk-modal-body">
                    		<button class="uk-modal-close-default" type="button" uk-close></button>

                    		<div class="uk-grid-small uk-flex-middle" uk-grid>
                    			<div class="uk-width-auto">
                                    <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_LIDERANCA/".$dados['img']."&w=90&h=90' class='uk-preserve-width uk-border-circle' />";?>
                    			</div>
                    			<div class="uk-width-expand">
                    				<h3 class="uk-heading-bullet uk-margin-remove-bottom"><?php echo $dados['nome']; ?></h3>
                    				<p class="uk-text-meta uk-margin-remove-top">
                    					<span class="clearfix"></span>
                    					<time>
                    						<?php if ($dados['facebook'] == NULL) { } else { ?>
                                                <a href="http://fb.com/<?php echo $dados['facebook'];?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="class-social fb fa fa-facebook"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($dados['twitter'] == NULL) { } else { ?>
                                                <a href="http://twitter.com/<?php echo $dados['twitter'];?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="class-social tw fa fa-twitter"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($dados['instagram'] == NULL) { } else { ?>
                                                <a href="http://instagram.com/<?php echo $dados['instagram'];?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="class-social ig fa fa-instagram"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($dados['youtube'] == NULL) { } else { ?>
                                                <a href="http://youtube.com/user/<?php echo $dados['youtube'];?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="class-social youtube fa fa-youtube"></i>
                                                </a>
                                            <?php } ?>

                                            <?php if ($dados['linkedin'] == NULL) { } else { ?>
                                                <a href="http://linkedin.com/in/<?php echo $dados['linkedin'];?>" target="_blank" rel="noopener noreferrer">
                                                    <i class="class-social linkedin fa fa-linkedin"></i>
                                                </a>
                                            <?php } ?>
                    					</time>
                    					<br><br>
                    					<time>Atruição: <span class="uk-button uk-button-link"><?php echo $dados['funcao']; ?></span> | </time>
                    					<time>Cargo: <span class="uk-button uk-button-link"><?php echo $dados['titulo_categoria']; ?></span></time>
                    				</p>
                    			</div>
                    		</div>
                    		<p><?php echo $dados['texto']; ?></p>
                    	</div>
                    </div>
                    <!--

					MODAL > EQUIPE

                    -->

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
                            url: 'modulos/lideranca/excluir.php',
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
