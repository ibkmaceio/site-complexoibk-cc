<?php include "inc/header.php"; ?>

<section class="title-interno">
	<div class="banner-interno">
		<div class="uk-cover-container">
			<div class="mask"></div>
			<img class="img-responsive" src="./cms/timthumb.php?src=assets/img/hands-up.jpg&h=480&w=1380" alt="Voluntarios IBK">

			<div class="titulo-interno">
				<div class="margin-titulo">
					<div>
						<h1>Faça parte da IBK</h1>
						<p style="margin-top: -10px; font-size: 22px;">Seja voluntário em um dos nossos ministerios!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>

<section class="apresentacao-interna int checkout" style="padding: 30px 0;">
	<div class="container pagamento">
		<div class="row">

			<?php
			$sql_vol = "SELECT * FROM _voluntarios_intro WHERE ativo = 'S' ORDER BY id ASC";
			$bd->consulta($sql_vol);
			$bd->first();
			$row = $bd->getRows();

			for($i=1; $i<=$row; $i++){
			$dados_vol = $bd->getDados();
			?>

			<div class="col-sm-4 text-left">
				<h3><?php echo $dados_vol['titulo']; ?></h3>
				<p><?php echo $dados_vol['texto']; ?></p>
			</div>
			<?php $bd->next(); } ?>

			<div class="col-sm-8">

				<form action="voluntarios-send.php" class="pagamento" id="form-voluntario" method="POST">
					<div class="modal__container" style="border-radius: 0px; background: #ebebeb;">
						<div class="modal__content">
							<h3>Com que ministério você mais se identifica?</h3>

							<?php
							$sql_voluntario = "SELECT * FROM _ministerios_categoria WHERE ativo = 'S' ORDER BY id ASC";
							$bd->consulta($sql_voluntario);
							$bd->first();
							$row = $bd->getRows();

							for($i=1; $i<=$row; $i++){
							$dados_voluntario = $bd->getDados();

							if ($dados_voluntario['slug'] == 'diretoria' OR $dados_voluntario['slug'] == 'administracao') {
								echo "";
							}else {
							?>
							<div class="inputGroup">
								<input id="<?php echo $dados_voluntario['id']; ?>" name="ministerio[]" type="checkbox" value="<?php echo $dados_voluntario['titulo']; ?>"/>
								<label for="<?php echo $dados_voluntario['id']; ?>"><?php echo $dados_voluntario['titulo']; ?></label>
							</div>
							<?php } $bd->next(); } ?>


							<div class="clearfix"></div>
							<hr>
							<div class="clearfix"></div>

							<div style="width: 70%;" class="width-mobile-100">
								<h3>Escolha uma das opções:</h3>
							</div>

							<div class="inputGroup">
								<input id="radio1" name="membro" type="radio" id="" value="S" />
								<label for="radio1">Sou membro</label>
							</div>

							<div class="inputGroup">
								<input id="radio2" name="membro" type="radio" id="" value="N" />
								<label for="radio2">Não sou membro</label>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<hr>

					<div class="modal__content">
						<div class="form-list row">
							<div class="col-sm-12 input-social mobile-info-footer">
								<h3 style="margin-bottom: 10px;">Dados pessoais</h3>
							</div>

							<div class="col-md-6 col-xs-12">
								<label for="">
									<p>Nome completo</p>
									<input type="text" placeholder="Ex: José da Silva" name="nome" id="nome">
									<div class="clearfix"></div>
								</label>
							</div>

							<div class="col-md-6 col-xs-12">
								<label for="">
									<p>Email</p>
									<input type="text" placeholder="Ex: email@contato.com.br" name="email" id="email">
									<div class="clearfix"></div>
								</label>
							</div>

							<div class="col-md-6 col-xs-12">
								<label for="">
									<p>Telefone Celular</p>
									<input type="text" placeholder="(99) 99999-9999" class="telefone" name="telefone" id="telefone">
									<div class="clearfix"></div>
								</label>
							</div>

							<div class="col-md-6 col-xs-12">
								<label for="">
									<p>Data de Nascimento</p>
									<input type="text" placeholder="99/99/9999" class="dt_nascimento" name="dt_nascimento" id="dt_nascimento">
									<div class="clearfix"></div>
								</label>
							</div>

							<div class="clearfix"></div>

							<div class="col-sm-12 input-social mobile-info-footer">
								<h3 style="margin-bottom: 10px;">Redes Sociais</h3>
							</div>
							<div class="col-md-4 col-xs-12 input-social">
								<label for="">
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-facebook"></i></span>
										<input type="text" value="" name="facebook" id="facebook" class="" placeholder="Ex.: ibkmaceio">
									</div>
								</label>
							</div>

							<div class="col-md-4 col-xs-12 input-social">
								<label for="">
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-instagram"></i></span>
										<input type="text" value="" name="instagram" id="instagram" class="" placeholder="Ex.: ibkmaceio">
									</div>
								</label>
							</div>

							<div class="col-md-4 col-xs-12 input-social">
								<label for="">
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-twitter"></i></span>
										<input type="text" value="" name="twitter" id="twitter" class="" placeholder="Ex.: ibkmaceio">
									</div>
								</label>
							</div>

							<div class="col-md-12 col-xs-12 input-social" style="margin-top: 30px;">
								<h3 style="margin-bottom: 10px;">Escreva um pouco <b>sobre você</b> e sobre suas <b>experiências ministeriais</b></h3>
								<label for="">
									<textarea name="texto" id="texto" cols="30" rows="8" placeholder="Digite uma mensagem ..."></textarea>
									<div class="clearfix"></div>
								</label>
							</div>

							<div class="clearfix"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 alinha-centro margin-auto">
							<input type="hidden" value="envia_voluntario" name="action">
							<!-- <a href="#prosseguir-forma-pagamento-link" class="prosseguir tira-padding-right">
								Enviar mensagem <i class="fa fa-mouse-pointer"></i>
							</a> -->
							<button type="submit" class="prosseguir tira-padding-right">
								Enviar mensagem <i class="fa fa-mouse-pointer"></i>
							</button>
							<!-- <button type="submit" id="prosseguir-forma-pagamento" class="prosseguir" disabled>Preencha os campos para prosseguir <i class="fa fa-hand-pointer"></i></button> -->
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>