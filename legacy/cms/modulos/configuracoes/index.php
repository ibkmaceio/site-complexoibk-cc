<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>


<!--



CONFIGURACOES



-->


<?php
$query2 = "SELECT * FROM _configuracoes WHERE id = '$_REQUEST[id]'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'editar'){

	$sql = " UPDATE _configuracoes SET
	cep 				= '".$_POST['cep']."',
	endereco 			= '".$_POST['endereco']."',
	numero 				= '".$_POST['numero']."',
	complemento 		= '".$_POST['complemento']."',
	cidade 				= '".$_POST['cidade']."',
	estado 				= '".$_POST['estado']."',
	nome_responsavel 	= '".$_POST['nome_responsavel']."',
	email 				= '".$_POST['email']."',
	telefone 			= '".$_POST['telefone']."',
	site 				= '".$_POST['site']."',
	facebook 			= '".$_POST['facebook']."',
	twitter 			= '".$_POST['twitter']."',
	linkedin 			= '".$_POST['linkedin']."',
	youtube 			= '".$_POST['youtube']."',
	instagram 			= '".$_POST['instagram']."',
	whatsapp 			= '".$_POST['whatsapp']."',
	_site_titulo 		= '".$_POST['_site_titulo']."',
	_site_descricao 	= '".(strip_tags($_POST['_site_descricao']))."',
	ativo 				= 'S'
	WHERE id = '".$_POST['id']."'
	";

	if($bd->consulta($sql)){
		echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertEd();
            }
        </script>";
    } else {
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertError();
            }
        </script>";
    }
}

?>

<h3 class="uk-heading-line"><span>Ajustes</span></h3>

<div uk-alert class="uk-alert-danger" id="message_alert" style="display:none;">
    <a class="uk-alert-close" uk-close></a>
    <h3>Ocorreu um erro no cadastro!</h3>
</div>

<div class="uk-overflow-auto uk-background-muted uk-padding">
	<form class="uk-form-stacked" action="" method="post" enctype="multipart/form-data">


		<ul uk-accordion>

			<!--




			CONFIGURAÇÕES > EMPRESA




			-->
		    <li>
		        <h3 class="uk-accordion-title">Empresa</h3>
		        <div class="uk-accordion-content">


		        	<div class="row">
		        		<div class="col-sm-12">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="nome">Nome</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: home"></span>
		        					<input class="uk-input uk-form-width-large" name="empresa" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['empresa']; ?>" disabled>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-12">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="nome">CEP</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: chevron-right"></span>
		        					<input class="uk-input cep" name="cep" id="cep" type="text" placeholder="99.999-999" onblur="pesquisacep(this.value);" value="<?php echo $dados['cep']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-6">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="endereco">Endereço</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: location"></span>
		        					<input class="uk-input uk-form-width-large" name="endereco" id="endereco" type="text" placeholder="Rua, Avenida, Praça" value="<?php echo $dados['endereco']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-2">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="nome">Número</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: chevron-right"></span>
		        					<input class="uk-input uk-form-width-large" name="numero" type="text" placeholder="99" value="<?php echo $dados['numero']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-4">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="nome">Complemento</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: chevron-right"></span>
		        					<input class="uk-input uk-form-width-large" name="complemento" type="text" placeholder="Proximo a ..." value="<?php echo $dados['complemento']; ?>">
		        				</div>
		        			</div>
		        		</div>
		        	</div>

		        	<div class="row">
		        		<div class="col-sm-4">
		        			<div class="uk-margin">
		        				<label for="">Cidade</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: chevron-right"></span>
		        					<input class="uk-input uk-form-width-large" name="cidade" id="cidade" type="text" placeholder="Proximo a ..." value="<?php echo $dados['cidade']; ?>">
		        				</div>
			        			<!-- <select class="uk-select" name="cidade">
			        				<option value="<?php echo $dados['cidade']; ?>"><?php echo $dados['cidade']; ?></option>
			        				<option value="<?php echo $dados['cidade']; ?>">-</option>
			        				<?php
			        				$sql_cidade = "SELECT * FROM _cidade ORDER BY nome ASC ";
			        				$bd->consulta($sql_cidade);
			        				$bd->first();
			        				$rows = $bd->getRows();

			        				for($i=1; $i<=$rows; $i++){
			        					$dados_cidade = $bd->getDados();
		        					?>
		        					<option value="<?php echo $dados_cidade['nome']; ?>"><?php echo $dados_cidade['nome']; ?></option>
		        					<?php $bd->next(); }?>
		        				</select> -->
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label for="">Estado</label>
		        				<div class="uk-inline">
			        				<span class="uk-form-icon" uk-icon="icon: chevron-right"></span>
			        				<input class="uk-input uk-form-width-large" name="estado" id="estado" type="text" placeholder="Proximo a ..." value="<?php echo $dados['estado']; ?>">
			        			</div>
			        			<!-- <select class="uk-select" name="estado">
			        				<option  value="<?php echo $dados['estado']; ?>" ><?php echo $dados['estado']; ?></option>
			        				<?php
			        				$sql_estado = "SELECT * FROM _estado ORDER BY nome ASC";
			        				$bd->consulta($sql_estado);
			        				$bd->first();
			        				$rows = $bd->getRows();

			        				for($i=1; $i<=$rows; $i++){
			        					$dados_estado = $bd->getDados();
			        					?>
		        					<option value="<?php echo $dados_estado['nome']; ?>"><?php echo $dados_estado['nome']; ?></option>
		        					<?php $bd->next(); }?>
		        				</select> -->
	        				</div>
	        			</div>
		        	</div>


		        	<div class="row">
		        		<div class="col-lg-5">
		        			<div class="uk-margin">
		        				<label for="">Nome do responsável</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: user"></span>
		        					<input name="nome_responsavel" id="nome_responsavel" placeholder="Joao da Silva" class="uk-input uk-form-width-large" type="text" value="<?php echo $dados['nome_responsavel']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-lg-4">
		        			<div class="uk-margin">
		        				<label for="">Email do responsável</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: mail"></span>
		        					<input name="email" id="email" placeholder="email@email.com" class="uk-input uk-form-width-large" type="text" value="<?php echo $dados['email']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-lg-3">
		        			<div class="uk-margin">
		        				<label for="">Telefone para contato</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: phone"></span>
		        					<input name="telefone" id="telefone" placeholder="(99) 9999-9999" class="telefone uk-input uk-form-width-large" type="text" value="<?php echo $dados['telefone']; ?>">
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-lg-4">
		        			<div class="uk-margin">
		        				<label for="">Site da Empresa</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: link"></span>
		        					<input name="site" id="site" placeholder="http://www.meusite.com.br" class="uk-input uk-form-width-large" type="text" value="<?php echo $dados['site']; ?>">
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		        </div>
		    </li>




			<!--




			CONFIGURAÇÕES > SEO




			-->
		    <li>
		        <h3 class="uk-accordion-title">SEO</h3>
		        <div class="uk-accordion-content">

		        	<div class="row">
		        		<div class="col-sm-12">
		        			<div class="uk-margin">
		        				<label class="uk-form-label">Titulo da página</label>
		        				<div class="uk-inline">
		        					<span class="uk-form-icon" uk-icon="icon: world"></span>
		        					<input name="_site_titulo" id="_site_titulo" placeholder="Titulo da página" class="uk-input uk-form-width-large" type="text" value="<?php echo $dados['_site_titulo']; ?>">
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-12">
		        			<div class="uk-margin">
		        				<label class="uk-form-label">Descrição do Site</label>
		        				<div class="uk-form-controls">
		        					<textarea name="_site_descricao" rows="8" placeholder="Descripción del sitio web..." class="uk-textarea"><?php echo $dados['_site_descricao']; ?></textarea>
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		        </div>
		    </li>






			<!--





			CONFIGURAÇÕES > TAGS




			-->
		    <li>
		        <h3 class="uk-accordion-title">Tags</h3>
		        <div class="uk-accordion-content">

					<?php
						$sql_tag = mysql_query("SELECT * FROM _tags ORDER BY id DESC");
						while ($dados_tag = mysql_fetch_array($sql_tag)) {
					?>
					<span class="tagson" id="tr_<?php echo $dados_tag['id'];?>">
						<?php echo $dados_tag['tag'];?>
						<a href="javascript:void();" data-id="<?php echo $dados_tag['id'];?>" class="deletar" title="Excluir > <?php echo $dados_tag['tag'];?>" uk-tooltip><i class="fa fa-times-circle"></i></a>
					</span>
					<?php } ?>
					<a href="modulos/tags/cadastrar.php" class="btn btn-xs btn btn-success"> + Add Tags</a>
		        </div>
		    </li>



			<!--





			CONFIGURAÇÕES > REDES SOCIAIS





			-->
		    <li>
		        <h3 class="uk-accordion-title">Redes Sociais</h3>
		        <div class="uk-accordion-content">


		        	<div class="row">
		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="facebook">Facebook</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: facebook"></span>
		        						<input class="uk-input uk-form-width-large" name="facebook" type="text" placeholder="@usuario" value="<?php echo $dados['facebook']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="twitter">Twitter</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: twitter"></span>
		        						<input class="uk-input uk-form-width-large" name="twitter" type="text" placeholder="@usuario" value="<?php echo $dados['twitter']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="instagram">Instagram</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: instagram"></span>
		        						<input class="uk-input uk-form-width-large" name="instagram" type="text" placeholder="@usuario" value="<?php echo $dados['instagram']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="youtube">Youtube</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: youtube"></span>
		        						<input class="uk-input uk-form-width-large" name="youtube" type="text" placeholder="@usuario" value="<?php echo $dados['youtube']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="linkedin">Linkedin</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: linkedin"></span>
		        						<input class="uk-input uk-form-width-large" name="linkedin" type="text" placeholder="@usuario" value="<?php echo $dados['linkedin']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>

		        		<div class="col-sm-3">
		        			<div class="uk-margin">
		        				<label class="uk-form-label" for="whatsapp">Whatsapp</label>
		        				<div class="uk-form-controls">
		        					<div class="uk-inline">
		        						<span class="uk-form-icon" uk-icon="icon: whatsapp"></span>
		        						<input class="uk-input uk-form-width-large" name="whatsapp" type="text" placeholder="551199999999" value="<?php echo $dados['whatsapp']; ?>">
		        					</div>
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		        </div>
		    </li>
		</ul>

		<div class="clearfix"></div>
		<hr>

		<div class="row">
			<div class="col-sm-12 text-right">
				<input type="hidden" name="id" value="<?php echo $dados['id'];?>">
				<input type="hidden" value="editar" name="action">
				<a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
				<button class="uk-button uk-label-success">Atualizar</button>
			</div>
		</div>

	</form>
</div>

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>

<script>
	/*





	EXCLUIR TAGS





	*/
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
                            url: 'modulos/tags/excluir.php',
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