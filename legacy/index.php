<?php include "inc/header.php"; ?>

    <section class="banner">
		<div class="container-fluid tira-padding">
			<div class="uk-position-relative uk-visible-toggle uk-light" uk-slideshow="animation: scale;autoplay: true;min-height: 300; max-height: 410">
				<ul class="uk-slideshow-items">
					<?php
	                $sql = mysql_query("SELECT * FROM _destaques WHERE ativo ='S' ORDER BY id DESC LIMIT 5");
	                $count_banner = 1;
	                while ($dados_b_destaque = mysql_fetch_array($sql)) {

	                	if($count_banner == 1){
	                		$msg_active = "uk-transition-active";
	                	}else{
	                		$msg_active = "";
	                	}
	                ?>
					<li>
                        <?php
                            if ($dados_b_destaque['tipo_destaque'] == "I") {
                                if ($dados_b_destaque['link_externo'] == 'S') { $target = "target='_BLANK'"; } else {}
                        ?>
                        <a href="<?php echo $dados_b_destaque['link_imagem']; ?>" <?php $target; ?>>
                            <?php echo "<img src='./cms/assets/uploads/_DESTAQUES/".$dados_b_destaque['img']."'/>"; ?>
                        </a>
						<?php } else { ?>

						<div id="video-minister"></div>
						<script>
							$('#video-minister').YTPlayer({
								fitToBackground: true,
								videoId: '<?php echo $dados_b_destaque['embed']; ?> ',
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
						<?php } ?>
					</li>
					<?php $count_banner++;  } ?>
				</ul>
				<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
				<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
			</div>
		</div>
	</section>

	<section class="programacao" style="margin-top: 40px;">
		<div class="container">
			<div class="row">
				<div class="titulo-principal">
					<h1>Conheça um pouco mais sobre nossa <strong>programação</strong></h1>
				</div>
			</div>

			<div uk-slider class="row">
				<div class="uk-position-relative">

					<div class="uk-slider-container uk-dark">
						<ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m">
							<?php
							$sql_prog = "SELECT * FROM _programacao WHERE ativo = 'S' ORDER BY data ASC";
							$bd->consulta($sql_prog);
							$bd->first();
							$row = $bd->getRows();

							for($i=1; $i<=$row; $i++){
							$dados_prog = $bd->getDados();
							?>
							<li>
								<div class="box-programacao">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tira-padding-left">
										<div class="data">
											<h1>
												<?php echo substr($dados_prog['data'],0,2); ?>
												<br>
												<h2><?php echo substr($dados_prog['data'],2,4); ?></h2>
											</h1>
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 tira-padding-left">
										<div class="info-programacao">
											<h1 class="info-h1-culto"><?php echo $dados_prog['titulo']; ?></h1>
											<span><i class="fa fa-calendar"></i> <?php echo $dados_prog['titulo_breve']; ?></span>
										</div>
									</div>
								</div>
							</li>
							<?php $bd->next(); } ?>
						</ul>
					</div>

					<div class="uk-visible@s">
						<a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
						<a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="voluntariado">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tira-padding-right tira-padding-left">
					<div class="box-voluntariado">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tira-padding">
							<div class="imagem-voluntariado">
								<img src="assets/img/img-voluntario.png" alt="">
							</div>
						</div>
						<div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 tira-padding-left">
							<a href="voluntarios">
								<div class="info-voluntariado">
									<h1>Voluntários <strong>Koinonia</strong></h1>
									<p>Se você tem talento e quer trabalhar nos ministérios da igreja, <a href="javascript:void();">Clique aqui</a></p>
									<i class="fas fa-angle-double-right"></i>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="novidades">
		<div class="container">
			<div class="row">
				<div class="titulo-principal">
					<h1><strong>Novidades</strong></h1>
					<p>Acompanhe nossas últimas novidades sobre eventos, artigos e noticias da <strong>Igreja Batista Koinonia</strong></p>
				</div>
			</div>
			<div class="row">

				<?php
				$sql_news = "SELECT * FROM _noticias WHERE destaque = 'S' AND ativo = 'S' ORDER BY data_criacao DESC LIMIT 1";
				$bd->consulta($sql_news);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_news = $bd->getDados();

				$dia            = date('d', strtotime($dados_news['data_criacao']));
				$mes_completo   = date('m', strtotime($dados_news['data_criacao']));
				$ano            = date('Y', strtotime($dados_news['data_criacao']));

				switch ($mes_completo){
					case 1:  $mes_completo = "Jan";  break;
					case 2:  $mes_completo = "Fev";  break;
					case 3:  $mes_completo = "Mar";  break;
					case 4:  $mes_completo = "Abr";  break;
					case 5:  $mes_completo = "Mai";  break;
					case 6:  $mes_completo = "Jun";  break;
					case 7:  $mes_completo = "Jul";  break;
					case 8:  $mes_completo = "Ago";  break;
					case 9:  $mes_completo = "Set";  break;
					case 10: $mes_completo = "Out";  break;
					case 11: $mes_completo = "Nov";  break;
					case 12: $mes_completo = "Dez";  break;
				}

				?>
				<a href="novidades/<?php echo $dados_news['categoria_noticia_slug']; ?>/<?php echo $dados_news['slug']; ?>">
					<div class="box-novidade-destaque">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 tira-padding">

							<?php if ($dados_news['img'] == NULL) { ?>
								<img src="./cms/timthumb.php?src=./assets/img/avatar_3.png&w=560&h=320"/>
							<?php } else { ?>

								<img src="./cms/timthumb.php?src=./cms/assets/uploads/_NOTICIAS/<?php echo $dados_news['img']; ?>&w=560&h=320"/>
							<?php } ?>

						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="info-novidade">
								<header>
									<div class="categoria-data">
										<h6><?php echo $dados_news['categoria_noticia']; ?></h6>
										<h5><?php echo $dia; ?> <?php echo $mes_completo; ?> '<?php echo $ano; ?></h5>
									</div>
									<div class="hora" uk-tooltip="title: Duração da leitura; pos: top-right">

										<?php
										$mycontent = $dados_news['texto'];
										$word = str_word_count(strip_tags($mycontent));
										$m = floor($word / 270);
										$s = floor($word % 270 / (270 / 60));
										$est = $m . ' min';
										?>
										<i class="fa fa-hourglass-half"></i> <span class="timeread"><?php echo $est; ?></span>
									</div>
								</header>
								<h3><?php echo $dados_news['titulo']; ?></h3>
								<p><?php echo $dados_news['breve_descricao']; ?></p>
								<span>Por <?php echo $dados_news['autor']; ?></span>
							</div>
						</div>
					</div>
				</a>
				<?php $bd->next(); } ?>
			</div>
			<div class="row">

				<?php
				$sql_news_2 = "SELECT * FROM _noticias WHERE ativo = 'S' AND destaque = 'N' ORDER BY data_criacao DESC LIMIT 3";
				$bd->consulta($sql_news_2);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_news_2 = $bd->getDados();

				$dia            = date('d', strtotime($dados_news_2['data_criacao']));
				$mes_completo   = date('m', strtotime($dados_news_2['data_criacao']));
				$ano            = date('Y', strtotime($dados_news_2['data_criacao']));

				switch ($mes_completo){
					case 1:  $mes_completo = "Jan";  break;
					case 2:  $mes_completo = "Fev";  break;
					case 3:  $mes_completo = "Mar";  break;
					case 4:  $mes_completo = "Abr";  break;
					case 5:  $mes_completo = "Mai";  break;
					case 6:  $mes_completo = "Jun";  break;
					case 7:  $mes_completo = "Jul";  break;
					case 8:  $mes_completo = "Ago";  break;
					case 9:  $mes_completo = "Set";  break;
					case 10: $mes_completo = "Out";  break;
					case 11: $mes_completo = "Nov";  break;
					case 12: $mes_completo = "Dez";  break;
				}
				?>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tira-padding-left">
					<a href="novidades/<?php echo $dados_news_2['categoria_noticia_slug']; ?>/<?php echo $dados_news_2['slug']; ?>">
						<div class="box-novidade">

							<?php if ($dados_news_2['img'] == NULL) { ?>
								<img src="./cms/timthumb.php?src=./assets/img/avatar_3.png&w=350&h=240"/>
							<?php } else { ?>

								<img src="./cms/timthumb.php?src=./cms/assets/uploads/_NOTICIAS/<?php echo $dados_news_2['img']; ?>&w=350&h=240"/>
							<?php } ?>


							<article>
								<header>
									<div class="categoria-data">
										<h6><?php echo $dados_news_2['categoria_noticia']; ?></h6>
										<h5><?php echo $dia; ?> <?php echo $mes_completo; ?> '<?php echo $ano; ?></h5>
									</div>
									<div class="hora" uk-tooltip="title: Duração da leitura; pos: top-right">

										<?php
										$mycontent = $dados_news_2['texto'];
										$word = str_word_count(strip_tags($mycontent));
										$m = floor($word / 270);
										$s = floor($word % 270 / (270 / 60));
										$est = $m . ' min';
										?>
										<i class="fa fa-hourglass-half"></i> <span class="timeread"><?php echo $est; ?></span>
									</div>

								</header>
								<h3><?php echo $dados_news_2['titulo']; ?></h3>
								<span>Por <?php echo $dados_news_2['autor']; ?></span>
							</article>
						</div>
					</a>
				</div>
				<?php $bd->next(); } ?>
			</div>
		</div>
	</section>

	<section class="calendario">
		<div class="container">
			<div class="row">
				<div class="titulo-principal" style="max-width: 650px;">
					<div class="dailyVersesWrapper"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					<div class="titulo-left">
						<h1>#VcNa<b>IBK</b></h1>
						<p>Galeria de fotos com todos os clicks da IBK você encontra aqui! Confira as fotos dos nossos cultos e encontros</p>
						<a href="nossos-eventos"><h2>Visite nosso calendario de eventos</h2></a>
					</div>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
					<div class="banner-calendario owl-carousel owl-theme">

						<?php
						$sql_midia_home = "SELECT * FROM _midia WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 5";
						$bd->consulta($sql_midia_home);
						$bd->first();
						$row = $bd->getRows();

						for($i=1; $i<=$row; $i++){
						$dados_midia = $bd->getDados();

						$dia            = date('d', strtotime($dados_midia['data_criacao']));
						$mes_completo   = date('m', strtotime($dados_midia['data_criacao']));
						$ano            = date('Y', strtotime($dados_midia['data_criacao']));

						switch ($mes_completo){
							case 1:  $mes_completo = "Jan";  break;
							case 2:  $mes_completo = "Fev";  break;
							case 3:  $mes_completo = "Mar";  break;
							case 4:  $mes_completo = "Abr";  break;
							case 5:  $mes_completo = "Mai";  break;
							case 6:  $mes_completo = "Jun";  break;
							case 7:  $mes_completo = "Jul";  break;
							case 8:  $mes_completo = "Ago";  break;
							case 9:  $mes_completo = "Set";  break;
							case 10: $mes_completo = "Out";  break;
							case 11: $mes_completo = "Nov";  break;
							case 12: $mes_completo = "Dez";  break;
						}

						?>
						<div class="item">
							<a href="midia/<?php echo $dados_midia['categoria_noticia_slug']; ?>/<?php echo $dados_midia['slug']; ?>">
								<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 tira-padding-right mobile-padding">
									<div class="imagem">

										<?php if ($dados_midia['img'] == NULL) { ?>
											<img class="left"  src="./cms/timthumb.php?src=./assets/img/avatar_3.png&w=500&h=313"/>
										<?php } else { ?>

											<img class="left" src="./cms/timthumb.php?src=./cms/assets/uploads/_MIDIA/<?php echo $dados_midia['img']; ?>&w=500&h=313"/>
										<?php } ?>

									</div>
								</div>
								<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 tira-padding-left tira-padding-right">
									<div class="texto">
										<div class="titulos">
											<h1><?php echo $dados_midia['titulo']; ?></h1>
											<p><i class="fa fa-calendar"></i> <?php echo $dia; ?> <?php echo $mes_completo; ?> '<?php echo $ano; ?></p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<?php $bd->next(); } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="videos">
		<div class="container">
			<div class="row">
				<div class="titulo-principal">
					<h1><strong>Vídeos Destaques</strong></h1>
					<p>Acompanhe nossos vídeos e transmissões ao vivo</p>
				</div>
			</div>
			<div class="row">
				<?php
				$sql_video = "SELECT * FROM _videos WHERE ativo = 'S' ORDER BY data_hora DESC LIMIT 6";
				$bd->consulta($sql_video);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_videos = $bd->getDados();

				$dia            = date('d', strtotime($dados_videos['data_hora']));
				$mes_completo   = date('m', strtotime($dados_videos['data_hora']));
				$ano            = date('Y', strtotime($dados_videos['data_hora']));

				switch ($mes_completo){
					case 1:  $mes_completo = "Jan";  break;
					case 2:  $mes_completo = "Fev";  break;
					case 3:  $mes_completo = "Mar";  break;
					case 4:  $mes_completo = "Abr";  break;
					case 5:  $mes_completo = "Mai";  break;
					case 6:  $mes_completo = "Jun";  break;
					case 7:  $mes_completo = "Jul";  break;
					case 8:  $mes_completo = "Ago";  break;
					case 9:  $mes_completo = "Set";  break;
					case 10: $mes_completo = "Out";  break;
					case 11: $mes_completo = "Nov";  break;
					case 12: $mes_completo = "Dez";  break;
				}
				?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="height: 370px;">
					<div class="box-video">
						<div class="row">
							<a href="videos/<?php echo $dados_videos['slug']; ?>">
				                <img src="<?php echo $dados_videos['imagem_hd']; ?>" class="img-fluid">
				            </a>
			            </div>
		            </div>
		            <div class="titulo-video">
		            	<span class="date"><i class="far fa-calendar-o"></i> <?php echo $dia; ?> <?php echo $mes_completo; ?> '<?php echo $ano; ?></span>
		            	<h4><?php echo $dados_videos['titulo']; ?></h4>
		            </div>
				</div>

				<div id="modal-media-youtube" class="uk-flex-top" uk-modal>
					<div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
						<button class="uk-modal-close-outside" type="button" uk-close></button>
						<iframe src="https://www.youtube-nocookie.com/embed/YE7VzlLtp-4" width="800" height="450" frameborder="0" uk-video></iframe>
					</div>
				</div>
				<?php $bd->next(); } ?>
			</div>

			<div class="clearfix"></div>
			<div style="margin-top: 80px;"></div>
			<a href="tv-ibk" class="btn-mais"><i class="fa fa-plus-circle"></i> Ver mais vídeos</a>
		</div>
	</section>



	<section class="leitura">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="titulo-left">
						<h1>Dica de leitura IBK</h1>
						<p>Confira uma série de livros que sugerimos aos nossos membros e visitantes nesse site. </p>

						<p>Esses livros tem gerado conhecimento e esclarecimentos.</p>
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 camada-img-leitura">
					<div class="banner-leitura owl-carousel owl-theme">

						<?php
						$sql_leitura = "SELECT * FROM _leitura WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 3";
						$bd->consulta($sql_leitura);
						$bd->first();
						$row = $bd->getRows();

						for($i=1; $i<=$row; $i++){
						$dados_leitura = $bd->getDados();
						?>
						<div class="item">
							<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 tira-padding-right">
								<div class="imagem">
									<img src="./cms/assets/uploads/_LEITURA/<?php echo $dados_leitura['img']; ?>" class="img-fluid">
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 tira-padding-left">
								<div class="texto">
									<div class="titulos">
										<h1><?php echo $dados_leitura['titulo']; ?></h1>
										<p><?php echo $dados_leitura['autor']; ?></p>
										<a href="<?php echo $dados_leitura['link']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-link"></i> Mais informações</a>
									</div>
								</div>
							</div>
						</div>
						<?php $bd->next(); } ?>

					</div>
				</div>
			</div>
		</div>
	</section>

<?php include "inc/footer.php"; ?>

<script>
	$.ajax({
		url:'https://dailyverses.net/getdailyverse.ashx?language=arc&isdirect=1&url=' + window.location.hostname,
		dataType: 'JSONP',
		success:function(json){
			$(".dailyVersesWrapper").prepend(json.html);
		}
	});
</script>