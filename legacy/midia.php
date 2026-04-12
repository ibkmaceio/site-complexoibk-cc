<?php include "inc/header.php"; ?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Mídia <i class="fas fa-angle-right"></i> <span>Acompanhe nossas atividades </span></h1>
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

<section class="apresentacao-interna int midia">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php
				$sql_midia = "SELECT * FROM _midia WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 1";
				$bd->consulta($sql_midia);
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

				<a href="midia/<?php echo $dados_midia['categoria_noticia_slug']; ?>/<?php echo $dados_midia['slug']; ?>">
				<div class="card">
					<div class="col-sm-6 tira-padding-right">
						<?php if ($dados_midia['img'] == NULL) { ?>
						<div class="thumbnail"><img class="left" src="./assets/img/avatar_3.png?format=1500w"/></div>

						<?php } else { ?>
						<div class="thumbnail"><img class="left" src="./cms/assets/uploads/_MIDIA/<?php echo $dados_midia['img']; ?>?format=1500w"/></div>
						<?php }  ?>

						<div class="col-sm-12 date-footer">
							<div class="col-sm-4">
								<div class="date">
									<h5><?php echo $dia; ?></h5>
									<h6><?php echo $mes_completo; ?> ' <?php echo $ano; ?></h6>
								</div>
							</div>
							<div class="col-sm-8 text-right tira-padding-right">
								<ul>
									<li><i class="fas fa-eye fa-2x"></i></li>
									<li><i class="fa fa-heart-o fa-2x"></i></li>
									<li><i class="fas fa-share-alt fa-2x"></i></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="right">
						<h1><?php echo $dados_midia['titulo']; ?></h1>
						<hr>
						<p><?php echo $dados_midia['breve_descricao']; ?></p>
					</div>

					<div class="clearfix"></div>
					<div class="fab"><i class="fa fa-arrow-right fa-3x"> </i></div>
				</div>
				</a>
				<?php $bd->next(); } ?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="clearfix"></div>
		<hr class="mobile-none ">

		<div class="row">
			<div class="col-sm-12 blog-card-margin tira-padding-left">

				<!-- ITEM MIDIA -->
				<?php
				$sql_midia2 = "SELECT * FROM _midia WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 1 , 2000";
				$bd->consulta($sql_midia2);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_midia2 = $bd->getDados();

				$dia            = date('d', strtotime($dados_midia2['data_criacao']));
				$mes_completo   = date('m', strtotime($dados_midia2['data_criacao']));
				$ano            = date('Y', strtotime($dados_midia2['data_criacao']));

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
				<div class="col-sm-4 tira-padding-right">
					<div class="example-2 card-list">

						<?php if ($dados_midia2['img'] == NULL) { ?>
						<div class="wrapper" style="background: url(./assets/img/avatar_3.png) center/cover no-repeat;">
						<?php } else { ?>

						<div class="wrapper" style="background: url(./cms/assets/uploads/_MIDIA/<?php echo $dados_midia2['img']; ?>) center/cover no-repeat;">
						<?php } ?>

							<div class="mask-image"></div>
							<div class="header">
								<div class="date">
									<span class="day"><?php echo $dia; ?></span>
									<span class="month"><?php echo $mes_completo; ?></span>
									<span class="year"><?php echo $ano; ?></span>
								</div>
								<ul class="menu-content">
									<?php
									$mycontent = $dados_midia2['texto'];
									$word = str_word_count(strip_tags($mycontent));
									$m = floor($word / 270);
									$s = floor($word % 270 / (270 / 60));
									$est = $m . ' min';
									?>
									<li>
										<a href="javascript:void();" class="fa fa-hourglass-half">
											<span style="left: -22px; font-size: 18px;"><?php echo $est; ?></span>
										</a>
									</li>
								</ul>
							</div>
							<div class="data">
								<div class="content" style="padding: 7.5em 2em;">
									<span class="author"><?php echo $dados_midia2['categoria_noticia']; ?></span>
									<h1 class="title">
										<a href="midia/<?php echo $dados_midia2['categoria_noticia_slug']; ?>/<?php echo $dados_midia2['slug']; ?>"><?php echo $dados_midia2['titulo']; ?></a>
									</h1>
									<p class="text"><?php echo $dados_midia2['breve_descricao']; ?></p>

									<div class="clearfix"></div>
									<a href="midia/<?php echo $dados_midia2['categoria_noticia_slug']; ?>/<?php echo $dados_midia2['slug']; ?>" class="button">Ver Mais</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $bd->next(); } ?>
			</div>
		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>