<?php include "inc/header.php"; ?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Novidades <i class="fas fa-angle-right"></i> <span>Fique por dentro dos nossos artigos!</span></h1>
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

<section class="apresentacao-interna cont titulo_arrow_2 midia">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tira-padding-left tira-padding-right">

				<?php

				$sql_news = "SELECT * FROM _noticias WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 1";
				$bd->consulta($sql_news);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_news = $bd->getDados();

				?>

				<div class="col-sm-8 tira-padding-right">
					<div class="example-2 card-list">

						<?php if ($dados_news['img'] == NULL) { ?>
							<div class="wrapper" style="background: url(./assets/img/avatar_3.png) center/cover no-repeat;">
						<?php } else { ?>
							<div class="wrapper" style="background: url(./cms/assets/uploads/_NOTICIAS/<?php echo $dados_news['img']; ?>) center/cover no-repeat;">
						<?php } ?>

							<div class="mask-image"></div>
							<div class="header">
								<div class="date">
									<?php
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
									<span class="day"><?php echo $dia; ?></span>
									<span class="month"><?php echo $mes_completo; ?></span>
									<span class="year"><?php echo $ano; ?></span>
								</div>
								<ul class="menu-content">
									<?php
									$mycontent = $dados_news['texto'];
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
									<span class="author"><?php echo $dados_news['categoria_noticia']; ?></span>
									<h1 class="title">
										<a href="novidades/<?php echo $dados_news['categoria_noticia_slug']; ?>/<?php echo $dados_news['slug']; ?>"><?php echo $dados_news['titulo']; ?></a>
									</h1>
									<p class="text"><?php echo $dados_news['breve_descricao']; ?></p>

									<div class="clearfix"></div>
									<a href="novidades/<?php echo $dados_news['categoria_noticia_slug']; ?>/<?php echo $dados_news['slug']; ?>" class="button">Ver Mais</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $bd->next(); } ?>


				<?php
				$sql_news2 = "SELECT * FROM _noticias WHERE ativo = 'S' ORDER BY data_criacao DESC LIMIT 1 , 2000";
				$bd->consulta($sql_news2);
				$bd->first();
				$row = $bd->getRows();

				for($i=1; $i<=$row; $i++){
				$dados_news2 = $bd->getDados();
				?>
				<div class="col-sm-4 tira-padding-right">
					<div class="example-2 card-list">
						<?php if ($dados_news2['img'] == NULL) { ?>
							<div class="wrapper" style="background: url(./assets/img/avatar_3.png) center/cover no-repeat;">
						<?php } else { ?>
							<div class="wrapper" style="background: url(./cms/assets/uploads/_NOTICIAS/<?php echo $dados_news2['img']; ?>) center/cover no-repeat;">
						<?php } ?>

							<div class="mask-image"></div>
							<div class="header">
								<div class="date">

									<?php
									$dia            = date('d', strtotime($dados_news2['data_criacao']));
									$mes_completo   = date('m', strtotime($dados_news2['data_criacao']));
									$ano            = date('Y', strtotime($dados_news2['data_criacao']));

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
									<span class="day"><?php echo $dia; ?></span>
									<span class="month"><?php echo $mes_completo; ?></span>
									<span class="year"><?php echo $ano; ?></span>
								</div>
								<ul class="menu-content">
									<?php
									$mycontent = $dados_news2['texto'];
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
									<span class="author"><?php echo $dados_news2['categoria_noticia']; ?></span>
									<h1 class="title">
										<a href="novidades/<?php echo $dados_news2['categoria_noticia_slug']; ?>/<?php echo $dados_news2['slug']; ?>"><?php echo $dados_news2['titulo']; ?></a>
									</h1>
									<p class="text"><?php echo $dados_news2['breve_descricao']; ?></p>

									<div class="clearfix"></div>
									<a href="novidades/<?php echo $dados_news2['categoria_noticia_slug']; ?>/<?php echo $dados_news2['slug']; ?>" class="button">Ver Mais</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $bd->next(); } ?>

				<div class="clearfix"></div>

			</div>
		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>