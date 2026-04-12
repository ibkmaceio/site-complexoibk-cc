<?php include "inc/header.php"; ?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Fale Conosco <i class="fas fa-angle-right"></i> <span>Envie uma mensagem para nossa equipe ministerial!</span></h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="colors">
	<div class="container">
		<div class="row">
			<div class="cor1"></div>
			<div class="cor2"></div>
			<div class="cor3"></div>
		</div>
	</div>
</section>

<div class="claerfix"></div>

<section class="apresentacao-interna int checkout" style="padding-bottom: 0;">
	<div class="container pagamento">
		<div class="row">
			<div class="col-sm-4 text-left">
				<h3><?php echo $dados_H_Footer['empresa']; ?></h3>

				<p style="margin-top:10px;"><i class="fas fa-map-marker-alt"></i> Endereço</p>
				<p><?php echo $dados_H_Footer['endereco']; ?>, <?php echo $dados_H_Footer['numero']; ?> <br> <?php echo $dados_H_Footer['complemento']; ?>, <?php echo $dados_H_Footer['cidade']; ?>/<?php echo $dados_H_Footer['estado']; ?></p>

				<br>
				<p><i class="fa fa-phone"></i> <?php echo $dados_H_Footer['telefone']; ?></p>

				<br>

				<p>Siga-nos</p>
				<div class="social-contact">
					<ul>
						<?php if ($dados_H_Footer['facebook'] == NULL) { } else { ?>
						<li><a href="https://www.facebook.com/<?php echo $dados_H_Footer['facebook']; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-square"></i></a></li>
						<?php } ?>

						<?php if ($dados_H_Footer['twitter'] == NULL) { } else { ?>
						<li><a href="https://www.twitter.com/<?php echo $dados_H_Footer['twitter']; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter-square"></i></a></li>
						<?php } ?>

						<?php if ($dados_H_Footer['instagram'] == NULL) { } else { ?>
						<li><a href="https://www.instagram.com/<?php echo $dados_H_Footer['instagram']; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
						<?php } ?>

						<?php if ($dados_H_Footer['linkedin'] == NULL) { } else { ?>
						<li><a href="https://www.linkedin.com/in/<?php echo $dados_H_Footer['linkedin']; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-square"></i></a></li>
						<?php } ?>

						<?php if ($dados_H_Footer['youtube'] == NULL) { } else { ?>
						<li><a href="https://www.youtube.com/<?php echo $dados_H_Footer['youtube']; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>
						<?php } ?>

					</ul>
				</div>
			</div>

			<div class="col-sm-8 pagamento">
				<form action="enviando-contato" method="POST">
					<div class="modal__container" style="border-radius: 0px; padding-top: 0;">
						<div class="modal__content">
							<ul class="form-list row">

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
										<p>Assunto</p>
										<select name="assunto" id="assunto" class="selectpicker">
											<option value="Dúvidas">Dúvidas</option>
											<option value="Auxilio Pastoral">Auxilio Pastoral</option>
											<option value="Outros">Outros</option>
										</select>
										<div class="clearfix"></div>
									</label>
								</div>

								<div class="col-md-12 col-xs-12" style="margin-top: 30px;">
									<label for="">
										<p>Mensagem</p>
										<textarea name="texto" id="texto" cols="30" rows="4" placeholder="Digite uma mensagem ..."></textarea>
										<div class="clearfix"></div>
									</label>
								</div>



								<div class="clearfix"></div>
							</ul>

							<div class="row">

								<div class="col-sm-12 alinha-centro margin-auto">
									<input type="hidden" value="envia_contato" name="action">
									<button type="submit" class="prosseguir tira-padding-right">
										Enviar mensagem <i class="fa fa-mouse-pointer"></i>
									</button>
									<!-- <button type="submit" id="prosseguir-forma-pagamento" class="prosseguir" disabled>Preencha os campos para prosseguir <i class="fa fa-hand-pointer"></i></button> -->
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>