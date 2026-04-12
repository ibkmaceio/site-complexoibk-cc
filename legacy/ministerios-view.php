<?php include "inc/header.php"; ?>

<?php

$categoria_ministerio_slug = mysql_real_escape_string($_GET['categoria_ministerio_slug']);

$sql_all = mysql_query("SELECT * FROM _ministerios WHERE categoria_ministerio_slug = '{$categoria_ministerio_slug}' ");
$dados_all = mysql_fetch_array($sql_all);

?>

<section class="title-interno">
	<div class="banner-interno">
		<div class="uk-cover-container">
			<div class="mask"></div>

			<?php if ($dados_all['video'] == "S") {?>
				<div id="video-minister"></div>
			<?php } else {?>
				<img src='./cms/timthumb.php?src=./cms/assets/uploads/_MINISTERIOS/<?php echo $dados_all['img'];?>&h=480&w=1380' class='img-responsive'/>
			<?php } ?>

			<div class="titulo-interno">
				<div class="margin-titulo">
					<div>
						<h1><?php echo $dados_all['titulo']; ?></h1>
						<p style="margin-top: -10px; font-size: 22px;"><?php echo $dados_all['breve_descricao']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="apresentacao-interna">
	<div class="container">
		<div class="row">
			<div class="titulo-apresentacao">
				<h1>Junte-se a nós para <strong>fazer a diferença</strong></h1>
				<p>Conheça mais sobre esse ministério e fique por dentro do que fazemos!</p>
			</div>
		</div>
	</div>
</section>

<section class="lideres">
	<div class="container">
		<div class="row">
			<div class="titulo-lideres">
				<h1>Lideres</h1>
				<p>Conheça a liderança desse ministério!</p>
			</div>
		</div>
		<div class="row">

			<?php

			$sqlTags = mysql_query(" SELECT * FROM _lideranca WHERE ministerio_slug = '".$categoria_ministerio_slug."' ");
			while ($dadosTags = mysql_fetch_array($sqlTags)) {
			?>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tira-padding box-lideres">
				<div class="">
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-5">
							<div class="imagem-lider">
								<?php
								$img_ext = strtolower(pathinfo($dadosTags['img'], PATHINFO_EXTENSION));
								if ($dadosTags['img'] == NULL || $img_ext === 'png') {
							?>
								<img src="./cms/timthumb.php?src=./assets/img/avatar_2.png&h=120&w=120" alt="">
								<?php } else { ?>
								<img src="./cms/timthumb.php?src=./cms/assets/uploads/_LIDERANCA/<?php echo $dadosTags['img']; ?>&h=120&w=120" alt="">
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-7 col-md-5 col-sm-12 col-xs-7 box-middle">
							<h4><?php echo $dadosTags['nome']; ?></h4>
							<p><?php echo $dadosTags['titulo_categoria']; ?></p>
						</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
</section>

<section class="cards">
	<div class="container">
		<div class="row">

			<!-- INTRODUCAO -->
			<a href="#modal-intro-<?php echo $dados_all['categoria_ministerio_slug']; ?>" uk-toggle>
				<div class="box-card-categoria">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 tira-padding">

						<div class="box-icon">
							<div>
								<i class="fa fa-align-left"></i>
							</div>
						</div>
						<div class="imagem-categoria">
							<img src='./cms/timthumb.php?src=./cms/assets/uploads/_MINISTERIOS/<?php echo $dados_all['introducao_img'];?>&h=350&w=550' class='img-responsive'/>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="info-novidade">
							<h3><?php echo $dados_all['introducao_titulo']; ?></h3>
							<p><?php echo $dados_all['introducao_subtitulo']; ?></p>
							<i class="fa fa-angle-double-right"></i>
						</div>
					</div>
				</div>

				<div id="modal-intro-<?php echo $dados_all['categoria_ministerio_slug']; ?>" class="uk-modal-full modal-ministerio" uk-modal>
					<div class="uk-modal-dialog">
						<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
						<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" uk-grid>
							<div class="uk-background-cover" style="background-image: url('./cms/assets/uploads/_MINISTERIOS/<?php echo $dados_all['introducao_img'];?>');" uk-height-viewport>
								<div class="mask">
									<div class="box-icon">
										<div>
											<i class="fa fa-align-left"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="uk-padding-large">
								<h3><?php echo $dados_all['introducao_titulo']; ?></h3>
								<p><?php echo $dados_all['introducao_descricao']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</a>


			<!-- EQUPE -->
			<a href="#modal-equipe-<?php echo $dados_all['categoria_ministerio_slug']; ?>" uk-toggle>
				<div class="box-card-categoria">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 tira-padding">

						<div class="box-icon">
							<div>
								<i class="fa fa-users"></i>
							</div>
						</div>

						<div class="imagem-categoria">
							<img src='./cms/timthumb.php?src=./cms/assets/uploads/_MINISTERIOS/<?php echo $dados_all['equipe_img'];?>&h=350&w=550' class='img-responsive'/>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="info-novidade">
							<h3><?php echo $dados_all['equipe_titulo']; ?></h3>
							<p><?php echo $dados_all['equipe_subtitulo']; ?></p>
							<i class="fa fa-angle-double-right"></i>
						</div>
					</div>
				</div>

				<div id="modal-equipe-<?php echo $dados_all['categoria_ministerio_slug']; ?>" class="uk-modal-full modal-ministerio" uk-modal>
					<div class="uk-modal-dialog">
						<button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
						<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" uk-grid>
							<div class="uk-background-cover" style="background-image: url('./cms/assets/uploads/_MINISTERIOS/<?php echo $dados_all['equipe_img'];?>');" uk-height-viewport>
								<div class="mask">
									<div class="box-icon">
										<div>
											<i class="fa fa-users"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="uk-padding-large">
								<h3><?php echo $dados_all['equipe_titulo']; ?></h3>
								<p><?php echo $dados_all['equipe_descricao']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>

<script>
	$('#video-minister').YTPlayer({
		fitToBackground: true,
		videoId: '<?php echo $dados_all['embed_video']; ?>',
		pauseOnScroll: false,
		playerVars: {
			modestbranding: 0,
			autoplay: 1,
			controls: 0,
			showinfo: 0,
			wmode: 'transparent',
			branding: 0,
			rel: 0,
			autohide: 0,
			origin: window.location.origin
		}
	});
</script>