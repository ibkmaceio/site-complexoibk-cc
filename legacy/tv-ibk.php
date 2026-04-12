<?php include "inc/header.php"; ?>

<section class="title-int" style="background: #222; padding-top: 35px;">
	<div class="container" style="padding-bottom: 0;">
		<div class="row">
			<div class="col-sm-12 tira-padding-right">
				<div class="title-int-text">
					<h1 class="pull-left">TV IBK <i class="fas fa-angle-right"></i> <span>Veja nossos videos e transmissões ao vivo!</span></h1>

					<div class="pull-right tira-padding-right">

						<?php


						$sql_live = mysql_query("SELECT * FROM _videos WHERE ativo ='S' AND ao_vivo = 'S' LIMIT 1");
						if ($dados_live = mysql_fetch_array($sql_live)) {
						?>
						<div class="btn-ao-vivo">
							<a href="ao-vivo" target="_blank" rel="noopener noreferrer"><i class="fa fa-circle"></i> Transmitindo Ao Vivo</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="colors" style="background: transparent; top: -9px;">
	<div class="container">
		<div class="row">
			<div class="cor1"></div>
			<div class="cor2"></div>
			<div class="cor3"></div>
		</div>
	</div>
</section>

<div class="claerfix"></div>

<div id="wrapper">
	<section class="slideshow" id="js-header">
		<?php
        $sql_vi_dest = mysql_query("SELECT * FROM _videos WHERE ativo ='S' AND destaque = 'S' ORDER BY data_hora DESC LIMIT 10");
        $count_banner = 1;
        while ($dados_v_des = mysql_fetch_array($sql_vi_dest)) {
        	$msg_active = $count_banner;
        	$msg_active2 = ($count_banner == 1) ? "is-current" : "is-next";
        ?>

		<div class="slideshow__slide js-slider-home-slide <?php echo $msg_active2; ?>" data-slide="<?php echo $msg_active; ?>">

			<?php if ($dados_v_des['ao_vivo'] == "S") { ?>
			<a href="ao-vivo" target="_blank" rel="noopener noreferrer">
			<?php }else { ?>
			<a href="videos/<?php echo $dados_v_des['slug']; ?>">
			<?php } ?>
				<div class="slideshow__slide-background-parallax background-absolute js-parallax" data-speed="-1" data-position="middle" data-target="#js-header">
					<div class="slideshow__slide-background-load-wrap background-absolute">
						<div class="slideshow__slide-background-load background-absolute">
							<div class="slideshow__slide-background-wrap background-absolute">
								<div class="slideshow__slide-background background-absolute">
									<div class="slideshow__slide-image-wrap background-absolute">
										<div class="slideshow__slide-image background-absolute" style="background-image: url('<?php echo $dados_v_des['imagem_hd']; ?>');"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="slideshow__slide-caption">
					<div class="slideshow__slide-caption-text">
						<div class="container js-parallax" data-speed="2" data-position="top" data-target="#js-header">
							<h1 class="slideshow__slide-caption-title"><i class="fab fa-youtube" style="font-size: 125px;margin-left: -5px; opacity: .3;"></i> </h1>
							<!-- <a class="slideshow__slide-caption-subtitle -load o-hsub -link" href="#">
								<span class="slideshow__slide-caption-subtitle-label">See how</span>
							</a> -->
						</div>
					</div>
				</div>
			</a>
		</div>
		<?php $count_banner++;  } ?>

		<div class="c-header-home_footer">
			<div class="o-container">
				<div class="c-header-home_controls -nomobile o-button-group">
					<div class="js-parallax is-inview" data-speed="1" data-position="top" data-target="#js-header">
						<button class="o-button -white -square -left js-slider-home-button js-slider-home-prev" type="button">
							<span class="o-button_label">
								<svg class="o-button_icon" role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-prev"></use></svg>
							</span>
						</button>
						<button class="o-button -white -square js-slider-home-button js-slider-home-next" type="button">
							<span class="o-button_label">
								<svg class="o-button_icon" role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-next"></use></svg>
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<svg xmlns="http://www.w3.org/2000/svg" style="position: absolute;">
		<symbol viewBox="0 0 18 18" id="arrow-next">
			<path id="arrow-next-arrow.svg" d="M12.6,9L4,17.3L4.7,18l8.5-8.3l0,0L14,9l0,0l-0.7-0.7l0,0L4.7,0L4,0.7L12.6,9z"/>
		</symbol>
		<symbol viewBox="0 0 18 18" id="arrow-prev">
			<path id="arrow-prev-arrow.svg" d="M14,0.7L13.3,0L4.7,8.3l0,0L4,9l0,0l0.7,0.7l0,0l8.5,8.3l0.7-0.7L5.4,9L14,0.7z"/>
		</symbol>
	</svg>
</div>

<div class="clearfix"></div>

<section class="videos">
	<div class="container">
		<div class="row">
			<div class="titulo-principal" style="padding-top: 100px;">
				<h1><strong>Vídeos Koinonia</strong></h1>
				<p>Acompanhe nossos vídeos e transmissões ao vivo</p>
			</div>
		</div>
		<div class="row">
			<?php
			$sql_video = "SELECT * FROM _videos WHERE ativo = 'S' ORDER BY data_hora DESC ";
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
			<?php $bd->next(); } ?>
		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>